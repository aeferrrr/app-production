<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Overhead;
use App\Models\Lokasi;
use Carbon\Carbon;
use App\Models\Pesanan;
use App\Models\JadwalProduksi;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index(){
         $jumlahKaryawan = User::where('role', 'karyawan')->count();
    $jumlahProduk = Produk::count();
    $jumlahBahan = Bahan::count();
    $jumlahOverhead = Overhead::count();
    $jumlahLokasi = Lokasi::count();

    // Tambahan
    $totalPesananBulanIni = Pesanan::whereMonth('tanggal_pesanan', Carbon::now()->month)->count();
    $produksiSelesaiBulanIni = JadwalProduksi::where('status_jadwal', 'selesai')
                                ->whereMonth('tanggal_mulai', Carbon::now()->month)->count();
    $totalUpahBulanIni = DB::table('jadwal_user')
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->sum('upah');

    // Ambil jadwal hari ini
    $jadwalHariIni = JadwalProduksi::with('pesanan', 'users')
                        ->whereDate('tanggal_mulai', Carbon::today())
                        ->get();

    return view('karyawan.index', compact(
        'jumlahKaryawan',
        'jumlahProduk',
        'jumlahBahan',
        'jumlahOverhead',
        'jumlahLokasi',
        'totalPesananBulanIni',
        'produksiSelesaiBulanIni',
        'totalUpahBulanIni',
        'jadwalHariIni'
    ));
    }
}
