@extends('layout.layout')
@section('title', 'Laporan Transaksi')
@section('content')
<div class="container-fluid">
    <h4 class="fw-bold py-3 mb-4">Laporan Produksi Selesai</h4>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode Pesanan</th>
                        <th>Tanggal Produksi</th>
                        <th>Produk</th>
                        <th>Karyawan</th>
                        <th>Total Upah</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($laporan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->pesanan->kode_pesanan ?? '-' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                        </td>
                        <td>
                            <ul>
                                @foreach($item->pesanan->detailPesanan as $detail)
                                    <li>{{ $detail->produk->nama_produk }} (Qty: {{ $detail->jumlah }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($item->users as $user)
                                    <li>{{ $user->name }} - Rp{{ number_format($user->pivot->upah) }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            Rp{{ number_format($item->users->sum('pivot.upah')) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data produksi yang selesai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
