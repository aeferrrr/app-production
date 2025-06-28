@extends('layout.layout')
@section('title', 'Laporan Transaksi')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Laporan Produksi Selesai
            </h5>

            <div class="p-3">
                <form method="GET" action="{{ route('admin.transaksi.item-laporan') }}" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label for="tanggal_mulai" class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                            value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_selesai" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                            value="{{ request('tanggal_selesai') }}">
                    </div>
                    <div class="col-md-6 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="bx bx-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.transaksi.item-laporan') }}" class="btn btn-sm btn-secondary">
                            <i class="bx bx-reset"></i> Reset
                        </a>
                        <a href="{{ route('admin.transaksi.export.excel', request()->only('tanggal_mulai', 'tanggal_selesai')) }}"
                            class="btn btn-sm btn-success">
                            <i class="bx bx-file"></i> Export Excel
                        </a>
                        <a href="{{ route('admin.transaksi.export.pdf', request()->only('tanggal_mulai', 'tanggal_selesai')) }}"
                            class="btn btn-sm btn-danger" target="_blank">
                            <i class="bx bxs-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </form>
            </div>

            <div class="table-responsive text-nowrap px-3 mb-3">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kode Pesanan</th>
                            <th>Tanggal Produksi</th>
                            <th>Produk</th>
                            <th>Karyawan</th>
                            <th>Total Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->pesanan->kode_pesanan ?? '-' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                </td>
                                <td>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($item->pesanan->detailPesanan as $detail)
                                            <li>- {{ $detail->produk->nama_produk }} (Qty: {{ $detail->jumlah }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($item->users as $user)
                                            <li>- {{ $user->name }} <span
                                                    class="badge bg-primary ms-1">Rp{{ number_format($user->pivot->upah) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <strong>Rp{{ number_format($item->users->sum('pivot.upah')) }}</strong>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data produksi yang selesai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $laporan->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>

@endsection
