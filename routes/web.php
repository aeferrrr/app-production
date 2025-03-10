<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Karyawan;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\KaryawanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Produk\ProdukController;
use App\Http\Controllers\Admin\Produk\BahanController;

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
    });
});

require __DIR__.'/auth.php';
