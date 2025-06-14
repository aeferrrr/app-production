<?php

namespace App\Http\Controllers\Admin\Pembuatan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\JadwalProduksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HargaPokokTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $pesanan = Pesanan::all();
        $hppData = null;
        $selectedPesanan = null;
        $totalJumlah = 0;
        $fakturData = null;

        if ($request->filled('pesanan_id')) {
            $data = $this->getHppData(
                $request->pesanan_id,
                (int) $request->input('bop', 0),
                (int) $request->input('btk', 0)
            );

            $selectedPesanan = $data['pesanan'];
            $hppData = $data['hppData'];
            $totalJumlah = $data['totalJumlah'];
            $fakturData = $data['fakturData'];
        }

        return view('admin.data-produk.hpp.index', compact(
            'pesanan',
            'selectedPesanan',
            'hppData',
            'totalJumlah',
            'fakturData'
        ));
    }

    public function exportPdf(Request $request)
    {
        $pesanan_id = $request->pesanan_id;
        $bop = (int) $request->bop ?? 0;
        $btk = (int) $request->btk ?? 0;

        $data = $this->getHppData($pesanan_id, $bop, $btk);

        $pdf = Pdf::loadView('admin.data-produk.hpp.pdf', [
            'pesanan' => $data['pesanan'],
            'bahan' => $data['hppData']['bahan'],
            'totalBBB' => $data['hppData']['totalBBB'],
            'totalBTK' => $data['hppData']['totalBTK'],
            'totalBOP' => $data['hppData']['totalBOP'],
            'totalHPP' => $data['hppData']['totalHPP'],
            'hppPerUnit' => $data['hppData']['hppPerUnit'],
            'totalJumlah' => $data['totalJumlah'],
            'fakturData' => $data['fakturData'],
        ]);

        return $pdf->download('hpp_' . $data['pesanan']->kode_pesanan . '.pdf');
    }

    private function calculateHpp($pesanan, $totalJumlah, $totalBTK, $totalBOP)
    {
        $bahan = [];
        $totalBBB = 0;

        foreach ($pesanan->detailPesanan as $detail) {
            $produk = $detail->produk;
            $jumlahPesanan = $detail->jumlah;

            foreach ($produk->produkBahan as $pb) {
                $jumlahBahan = $pb->jumlah_bahan * $jumlahPesanan;
                $hargaBahan = $pb->bahan->harga_bahan;
                $subtotal = $jumlahBahan * $hargaBahan;

                $bahan[] = [
                    'nama' => $pb->bahan->nama_bahan,
                    'jumlah' => $jumlahBahan,
                    'satuan' => $pb->satuan,
                    'harga' => $hargaBahan,
                    'subtotal' => $subtotal,
                ];

                $totalBBB += $subtotal;
            }
        }

        $totalHPP = $totalBBB + $totalBTK + $totalBOP;
        $hppPerUnit = $totalJumlah > 0 ? $totalHPP / $totalJumlah : 0;

        return [
            'bahan' => $bahan,
            'totalBBB' => $totalBBB,
            'totalBTK' => $totalBTK,
            'totalBOP' => $totalBOP,
            'totalHPP' => $totalHPP,
            'hppPerUnit' => $hppPerUnit,
        ];
    }

    private function getHppData($pesanan_id, $bopInput = 0, $btkInput = 0)
    {
        $pesanan = Pesanan::with('detailPesanan.produk.produkBahan.bahan')->findOrFail($pesanan_id);
        $totalJumlah = $pesanan->detailPesanan->sum('jumlah');

        $jadwalProduksi = JadwalProduksi::where('id_pesanan', $pesanan_id)->get();
        $totalBTK = $jadwalProduksi->sum('biaya_tenaga_kerja');

        if ($totalBTK == 0) {
            $totalBTK = $btkInput;
        }

        $hppData = $this->calculateHpp($pesanan, $totalJumlah, $totalBTK, $bopInput);

        $totalPendapatan = 0;
        foreach ($pesanan->detailPesanan as $detail) {
            $hargaJual = $detail->produk->harga_jual ?? 0;
            $jumlah = $detail->jumlah;
            $totalPendapatan += $hargaJual * $jumlah;
        }

        $labaKotor = $totalPendapatan - $hppData['totalHPP'];
        $marginPersen = $totalPendapatan > 0 ? ($labaKotor / $totalPendapatan) * 100 : 0;

        return [
            'pesanan' => $pesanan,
            'totalJumlah' => $totalJumlah,
            'hppData' => $hppData,
            'fakturData' => [
                'totalPendapatan' => $totalPendapatan,
                'labaKotor' => $labaKotor,
                'marginPersen' => $marginPersen,
            ],
        ];
    }
}
