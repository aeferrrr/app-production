@extends('layout.layout')
@section('title', 'Admin')
@section('content')

    <div class="container mt-3">
        <!-- Cards Statistik -->
        <div class="row">
            <!-- Total Karyawan -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar bg-primary text-white p-2 rounded-circle">
                                <i class="bx bx-user fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h6 class="text-muted mb-1">Total Karyawan</h6>
                                <h3 class="mb-0">{{ $jumlahKaryawan }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Produk -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar bg-success text-white p-2 rounded-circle">
                                <i class="bx bx-cube fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h6 class="text-muted mb-1">Total Produk</h6>
                                <h3 class="mb-0">{{ $jumlahProduk }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Bahan -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar bg-warning text-white p-2 rounded-circle">
                                <i class="bx bx-box fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h6 class="text-muted mb-1">Total Bahan</h6>
                                <h3 class="mb-0">{{ $jumlahBahan }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Overhead -->
        <div class="row mt-4">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar bg-danger text-white p-2 rounded-circle">
                                <i class="bx bx-money fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h6 class="text-muted mb-1">Total Overhead</h6>
                                <h3 class="mb-0">{{ $jumlahOverhead }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Posisi -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar bg-info text-white p-2 rounded-circle">
                                <i class="bx bx-map fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h6 class="text-muted mb-1">Total Posisi</h6>
                                <h3 class="mb-0">{{ $jumlahLokasi }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔥 QUICK ACTION BUTTONS -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-3">Aksi Cepat</h5>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="{{ route('admin.produk.create') }}" class="btn btn-outline-primary">
                                <i class="bx bx-plus-circle me-1"></i> Tambah Produk
                            </a>
                            <a href="#" class="btn btn-outline-success">
                                <i class="bx bx-calendar-plus me-1"></i> Buat Penjadwalan
                            </a>
                            <a href="{{ route('admin.bahan.create') }}" class="btn btn-outline-warning">
                                <i class="bx bx-package me-1"></i> Input Bahan
                            </a>
                            <!-- Aksi Cepat untuk Overhead -->
                            <a href="{{ route('admin.overhead.create') }}" class="btn btn-outline-danger">
                                <i class="bx bx-money me-1"></i> Input Overhead
                            </a>
                            <!-- Aksi Cepat untuk Posisi -->
                            <a href="{{ route('admin.lokasi.create') }}" class="btn btn-outline-info">
                                <i class="bx bx-map me-1"></i> Input Posisi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
