@extends('layout.layout')
@section('title', 'Dashboard Admin')

@section('content')
<div class="container mt-4">

    <!-- 📊 Statistik Master Data -->
    <div class="row">
        @php
            $cards = [
                ['label' => 'Total Karyawan', 'value' => $jumlahKaryawan, 'icon' => 'bx-user', 'bg' => 'primary'],
                ['label' => 'Total Produk', 'value' => $jumlahProduk, 'icon' => 'bx-cube', 'bg' => 'success'],
                ['label' => 'Total Bahan', 'value' => $jumlahBahan, 'icon' => 'bx-box', 'bg' => 'warning'],
                ['label' => 'Total Overhead', 'value' => $jumlahOverhead, 'icon' => 'bx-money', 'bg' => 'danger'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar bg-{{ $card['bg'] }} text-white p-2 rounded-circle me-3">
                            <i class="bx {{ $card['icon'] }} fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">{{ $card['label'] }}</h6>
                            <h4 class="mb-0">{{ $card['value'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 📦 Statistik Produksi -->
    <div class="row mt-4">
        @php
            $stats = [
                ['label' => 'Pesanan Bulan Ini', 'value' => $totalPesananBulanIni, 'icon' => 'bx-cart', 'bg' => 'secondary'],
                ['label' => 'Produksi Selesai', 'value' => $produksiSelesaiBulanIni, 'icon' => 'bx-check', 'bg' => 'dark'],
                // ['label' => 'Total Upah Dibayar', 'value' => 'Rp ' . number_format($totalUpahBulanIni, 0, ',', '.'), 'icon' => 'bx-wallet', 'bg' => 'success'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar bg-{{ $stat['bg'] }} text-white p-2 rounded-circle me-3">
                            <i class="bx {{ $stat['icon'] }} fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">{{ $stat['label'] }}</h6>
                            <h4 class="mb-0">{{ $stat['value'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 🗓️ Jadwal Produksi Hari Ini -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Produksi Hari Ini ({{ \Carbon\Carbon::today()->format('d M Y') }})</h5>
                </div>
                <div class="card-body table-responsive">
                    @if ($jadwalHariIni->count())
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Pemesan</th>
                                    <th>Jumlah</th>
                                    <th>Karyawan Bertugas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwalHariIni as $jadwal)
                                    <tr>
                                        <td>{{ $jadwal->pesanan->nama_pemesan }}</td>
                                        <td style="max-width: 200px;">
                                            <div style="max-height: 60px; overflow-y: auto;">
                                                @foreach ($jadwal->pesanan->detailPesanan as $detail)
                                                    <div>{{ $detail->produk->nama_produk }} ({{ $detail->jumlah }})</div>
                                                @endforeach
                                            </div>
                                        </td>
                                        
                                        <td>
                                            @foreach ($jadwal->users as $user)
                                                <span class="badge bg-primary">{{ $user->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $jadwal->status_jadwal === 'selesai' ? 'success' : 'warning' }}">
                                                {{ ucfirst($jadwal->status_jadwal) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                
                        </table>
                    @else
                        <p class="text-muted">Tidak ada jadwal produksi hari ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ⚡ Aksi Cepat -->
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
                        <a href="{{ route('admin.overhead.create') }}" class="btn btn-outline-danger">
                            <i class="bx bx-money me-1"></i> Input Overhead
                        </a>
                        <a href="{{ route('admin.lokasi.create') }}" class="btn btn-outline-info">
                            <i class="bx bx-map me-1"></i> Input Lokasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
