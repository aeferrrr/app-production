<?php

namespace App\Http\Controllers\Admin\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalProduksi;
use App\Models\Pesanan;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use PDF;

class LaporanTransaksi extends Controller
{
    public function index(Request $request)
{
    $laporan = JadwalProduksi::with([
            'pesanan.detailPesanan.produk',
            'users',
            'jadwalUser'
        ])
        ->where('status_jadwal', 'selesai')
        ->when($request->tanggal_mulai, function ($query) use ($request) {
            $query->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai);
        })
        ->when($request->tanggal_selesai, function ($query) use ($request) {
            $query->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai);
        })
        ->orderBy('tanggal_mulai', 'desc') // biar urut rapi
        ->paginate(5) // 🛑 paginate di sini!
        ->withQueryString(); // biar filter tetap kebawa saat ganti halaman

    return view('admin.data-transaksi.laporan-transaksi.read', compact('laporan'));
}


    public function exportExcel(Request $request)
    {
        $laporan = JadwalProduksi::with(['pesanan.detailPesanan.produk', 'users'])
            ->where('status_jadwal', 'selesai')
            ->when($request->tanggal_mulai, fn($q) => $q->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai))
            ->when($request->tanggal_selesai, fn($q) => $q->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai))
            ->get();

        return Excel::download(new LaporanExport($laporan), 'laporan-produksi.xlsx');
    }


    public function exportPdf(Request $request)
{
    $laporan = JadwalProduksi::with(['pesanan.detailPesanan.produk', 'users', 'jadwalUser'])
        ->where('status_jadwal', 'selesai')
        ->when($request->tanggal_mulai, fn($q) => $q->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai))
        ->when($request->tanggal_selesai, fn($q) => $q->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai))
        ->get();

    $pdf = PDF::loadView('admin.data-transaksi.laporan-transaksi.pdf', compact('laporan'));
    return $pdf->download('laporan-produksi.pdf');
}


}
