<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Karyawan;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\KaryawanController;
use App\Http\Controllers\Karyawan\ProduksiController;
//data master
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Produk\ProdukController;
use App\Http\Controllers\Admin\Produk\BahanController;
use App\Http\Controllers\Admin\Produk\OverheadController;
use App\Http\Controllers\Admin\Produk\LokasiController;
//produksi
use App\Http\Controllers\Admin\Pembuatan\ProdukBahanController;
use App\Http\Controllers\Admin\Pembuatan\PesananController;
use App\Http\Controllers\Admin\Pembuatan\JadwalProduksiController;
use App\Http\Controllers\Admin\Pembuatan\HargaPokokTransaksiController;
//Laporam
use App\Http\Controllers\Admin\Transaksi\LaporanTransaksi;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Middleware untuk karyawan
Route::middleware([Karyawan::class])->group(function () {
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::prefix('karyawan')->name('karyawan.')->group(function() {
    
        Route::prefix('produksi')->name('produksi.')->group(function () {
            // ... route pesanan dan produk bahan kamu
            Route::get('/item-penjadwalan', [ProduksiController::class, 'index'])->name('item-penjadwalan');
            Route::get('/create-penjadwalan', [ProduksiController::class, 'create'])->name('create-penjadwalan');
            Route::post('/store-penjadwalan', [ProduksiController::class, 'store'])->name('store-penjadwalan');
            Route::get('/edit-penjadwalan/{id}', [ProduksiController::class, 'edit'])->name('edit-penjadwalan');
            Route::put('/update-penjadwalan/{id}', [ProduksiController::class, 'update'])->name('update-penjadwalan');
            Route::post('/karyawan-update-status/{id}', [ProduksiController::class, 'karyawanUpdateStatus'])
            ->name('karyawan-update-status');
            Route::delete('/destroy-penjadwalan/{id}', [ProduksiController::class, 'destroy'])->name('destroy-penjadwalan');
        });
    });
});

// Middleware untuk admin
Route::middleware([Admin::class])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/item-karyawan', [AdminController::class, 'itemKaryawan'])->name('item-karyawan');
        
        // CRUD Karyawan
        Route::prefix('karyawan')->name('karyawan.')->group(function () {
            Route::delete('/destroy/{id}', [AdminController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'update'])->name('update');
            Route::get('/create', [AdminController::class, 'create'])->name('create');
            Route::post('/store', [AdminController::class, 'store'])->name('store');
        });

        // CRUD Produk
        Route::prefix('produk')->name('produk.')->group(function () {
            Route::get('/item-produk', [ProdukController::class, 'index'])->name('item-produk');
            Route::get('/create', [ProdukController::class, 'create'])->name('create');
            Route::post('/store', [ProdukController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ProdukController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ProdukController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [ProdukController::class, 'destroy'])->name('destroy');
        });

        // CRUD Bahan
        Route::prefix('bahan')->name('bahan.')->group(function () {
            Route::get('/item-bahan', [BahanController::class, 'index'])->name('item-bahan'); // Menampilkan daftar bahan
            Route::get('/create', [BahanController::class, 'create'])->name('create'); // Form tambah bahan
            Route::post('/store', [BahanController::class, 'store'])->name('store'); // Simpan bahan baru
            Route::get('/edit/{id}', [BahanController::class, 'edit'])->name('edit'); // Form edit bahan
            Route::put('/update/{id}', [BahanController::class, 'update'])->name('update'); // Update bahan
            Route::delete('/destroy/{id}', [BahanController::class, 'destroy'])->name('destroy'); // Hapus bahan
            Route::post('/bahan/update-harga', [BahanController::class, 'updateHarga'])->name('bahan.update-harga');
        });

                // CRUD Bahan
        Route::prefix('bahan')->name('bahan.')->group(function () {
            Route::get('/item-bahan', [BahanController::class, 'index'])->name('item-bahan'); // Menampilkan daftar bahan
            Route::get('/create', [BahanController::class, 'create'])->name('create'); // Form tambah bahan
            Route::post('/store', [BahanController::class, 'store'])->name('store'); // Simpan bahan baru
            Route::get('/edit/{id}', [BahanController::class, 'edit'])->name('edit'); // Form edit bahan
            Route::put('/update/{id}', [BahanController::class, 'update'])->name('update'); // Update bahan
            Route::delete('/destroy/{id}', [BahanController::class, 'destroy'])->name('destroy'); // Hapus bahan
            Route::post('/bahan/update-harga', [BahanController::class, 'updateHarga'])->name('bahan.update-harga');
        });
        // CRUD Overhead
        Route::prefix('overhead')->name('overhead.')->group(function () {
            Route::get('/item-overhead', [OverheadController::class, 'index'])->name('item-overhead'); // Menampilkan daftar overhead
            Route::get('/create', [OverheadController::class, 'create'])->name('create'); // Form tambah overhead
            Route::post('/store', [OverheadController::class, 'store'])->name('store'); // Simpan overhead baru
            Route::get('/edit/{id}', [OverheadController::class, 'edit'])->name('edit'); // Form edit overhead
            Route::put('/update/{id}', [OverheadController::class, 'update'])->name('update'); // Update overhead
            Route::delete('/destroy/{id}', [OverheadController::class, 'destroy'])->name('destroy'); // Hapus overhead
            Route::post('/overhead/update-harga', [OverheadController::class, 'updateHarga'])->name('overhead.update-harga');
        });
        //CRUD Lokasi
        Route::prefix('lokasi')->name('lokasi.')->group(function () {
            Route::get('/item-lokasi', [LokasiController::class, 'index'])->name('item-lokasi'); // Menampilkan daftar lokasi
            Route::get('/create', [LokasiController::class, 'create'])->name('create'); // Form tambah lokasi
            Route::post('/store', [LokasiController::class, 'store'])->name('store'); // Simpan lokasi baru
            Route::get('/edit/{id}', [LokasiController::class, 'edit'])->name('edit'); // Form edit lokasi
            Route::put('/update/{id}', [LokasiController::class, 'update'])->name('update'); // Update lokasi
            Route::delete('/destroy/{id}', [LokasiController::class, 'destroy'])->name('destroy'); // Hapus lokasi
        });

        //produksi

        //Mengelola Produksi

        // CRUD Relasi Produk & Bahan (Produksi)
        Route::prefix('produksi')->name('produksi.')->group(function () {
            Route::get('/item-produksi', [ProdukBahanController::class, 'index'])->name('item-produksi'); // Tampilkan daftar relasi
            Route::get('/create', [ProdukBahanController::class, 'create'])->name('create'); // Form tambah relasi
            Route::post('/store', [ProdukBahanController::class, 'store'])->name('store'); // Simpan relasi baru
            Route::get('/edit/{id}', [ProdukBahanController::class, 'edit'])->name('edit'); // Form edit relasi
            Route::put('/update/{id}', [ProdukBahanController::class, 'update'])->name('update'); // Update relasi
            Route::delete('/destroy/{id}', [ProdukBahanController::class, 'destroy'])->name('destroy');
        });
        // CRUD PEMESANAN
        Route::prefix('produksi')->name('produksi.')->group(function () {
            Route::get('/item-pesanan', [PesananController::class, 'index'])->name('item-pesanan');
            Route::get('/create-pesanan', [PesananController::class, 'create'])->name('create-pesanan');
            Route::post('/store-pesanan', [PesananController::class, 'store'])->name('store-pesanan');
            Route::get('/edit-pesanan/{id}', [PesananController::class, 'edit'])->name('edit-pesanan');
            Route::put('/update-pesanan/{id}', [PesananController::class, 'update'])->name('update-pesanan');
            Route::delete('/destroy-pesanan/{id}', [PesananController::class, 'destroy'])->name('destroy-pesanan');
        });
        // CRUD Penjadwalan
        Route::prefix('produksi')->name('produksi.')->group(function () {
            // ... route pesanan dan produk bahan kamu
            Route::get('/item-penjadwalan', [JadwalProduksiController::class, 'index'])->name('item-penjadwalan');
            Route::get('/create-penjadwalan', [JadwalProduksiController::class, 'create'])->name('create-penjadwalan');
            Route::post('/store-penjadwalan', [JadwalProduksiController::class, 'store'])->name('store-penjadwalan');
            Route::get('/edit-penjadwalan/{id}', [JadwalProduksiController::class, 'edit'])->name('edit-penjadwalan');
            Route::put('/update-penjadwalan/{id}', [JadwalProduksiController::class, 'update'])->name('update-penjadwalan');
            Route::delete('/destroy-penjadwalan/{id}', [JadwalProduksiController::class, 'destroy'])->name('destroy-penjadwalan');
        });
        //HPP
        Route::prefix('produksi')->name('produksi.')->group(function () {
            // ... route pesanan dan produk bahan kamu
            Route::get('/hpp', [HargaPokokTransaksiController::class, 'index'])->name('hpp');
            Route::get('/hpp/pdf', [HargaPokokTransaksiController::class, 'exportPdf'])->name('admin.produksi.hpp.pdf');

        });
        //laporam transaksi
        Route::prefix('transaksi')->name('transaksi.')->group(function () {
            Route::get('/item-laporan', [LaporanTransaksi::class, 'index'])->name('item-laporan');
            Route::get('/export-excel', [LaporanTransaksi::class, 'exportExcel'])->name('export.excel');
            Route::get('/export-pdf', [LaporanTransaksi::class, 'exportPdf'])->name('export.pdf');
        });
    });
});

require __DIR__.'/auth.php';
