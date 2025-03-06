<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Karyawan;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\KaryawanController;
use App\Http\Controllers\Admin\AdminController;


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
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/item-karyawan', [AdminController::class, 'itemKaryawan'])->name('admin.item-karyawan');
});
require __DIR__.'/auth.php';
