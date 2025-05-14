@extends('layout.layout')
@section('title', 'Dashboard Karyawan')

@section('content')
<div class="container mt-4">
    <!-- 🗓️ Jadwal Produksi Hari Ini -->
    <div class="row mt-1">
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


</div>
@endsection
