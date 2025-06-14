@extends('layout.layout')
@section('title', 'Dashboard Admin')

@section('content')
    <div class="container mt-4">
        <!-- Kartu Statistik -->
        <div class="d-flex flex-wrap justify-content-between gap-3">
            @php
                $cards = [
                    ['label' => 'Total Karyawan', 'value' => $jumlahKaryawan, 'icon' => 'bx-user', 'bg' => 'primary'],
                    ['label' => 'Total Produk', 'value' => $jumlahProduk, 'icon' => 'bx-cube', 'bg' => 'success'],
                    ['label' => 'Total Bahan', 'value' => $jumlahBahan, 'icon' => 'bx-box', 'bg' => 'warning'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="card shadow-sm flex-fill" style="min-width: 0;">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar bg-{{ $card['bg'] }} text-white p-3 rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="bx {{ $card['icon'] }} fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">{{ $card['label'] }}</h6>
                            <h4 class="mb-0">{{ $card['value'] }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Statistik Produksi -->
        <div class="row mt-4">
            @php
                $stats = [
                    [
                        'label' => 'Pesanan Bulan Ini',
                        'value' => $totalPesananBulanIni,
                        'icon' => 'bx-cart',
                        'bg' => 'secondary',
                    ],
                    [
                        'label' => 'Produksi Selesai',
                        'value' => $produksiSelesaiBulanIni,
                        'icon' => 'bx-check',
                        'bg' => 'dark',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
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
        <!-- Jadwal Produksi Hari Ini -->
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
                                                        <div>{{ $detail->produk->nama_produk }} ({{ $detail->jumlah }})
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                @foreach ($jadwal->users as $user)
                                                    <span class="badge bg-primary">{{ $user->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $jadwal->status_jadwal === 'selesai' ? 'success' : 'warning' }}">
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
        <!-- Grafik Penjualan -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Grafik Penjualan per Bulan ({{ date('Y') }})</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartPenjualan" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartPenjualan').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($penjualanPerBulan, 'bulan')) !!},
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: {!! json_encode(array_column($penjualanPerBulan, 'jumlah')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endsection
