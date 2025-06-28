@extends('layout.layout')
@section('title', 'Pemesanan')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Data Pemesanan
            </h5>
            @if (session('success'))
                <div class="alert alert-success mx-2">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                <!-- Form Filter & Search -->
                <div class="left-header d-flex justify-content-between align-items-center mx-3">
                    <form action="{{ route('admin.produksi.item-pesanan') }}" class="d-flex flex-wrap gap-2 p-1"
                        method="get">
                        @csrf
                        <input type="text" name="search" class="form-control w-auto" placeholder="Cari Pemesanan"
                            value="{{ request('search') }}">
                        <input type="date" name="tanggal_mulai" class="form-control w-auto"
                            value="{{ request('tanggal_mulai') }}">
                        <input type="date" name="tanggal_selesai" class="form-control w-auto"
                            value="{{ request('tanggal_selesai') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                        <a href="{{ route('admin.produksi.item-pesanan') }}"
                            class="btn btn-sm btn-outline-secondary">Reset</a>
                    </form>

                    <a href="{{ route('admin.produksi.create-pesanan') }}" class="btn btn-sm btn-primary ms-auto">
                        <i class="bx bx-plus"></i> Tambah Pemesanan
                    </a>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pemesanan</th>
                            <th>Nama Pemesan</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Catatan</th>
                            <th>Detail Produk</th>
                            <th style="width: 100px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $perPage = 5;
                            $currentPage = request()->get('page', 1);
                            $start = ($currentPage - 1) * $perPage;
                            $paginatedPesanan = $pesanan->slice($start, $perPage);
                        @endphp

                        @if ($paginatedPesanan->isEmpty())
                            <tr>
                                <td colspan="8">
                                    <div class="alert alert-warning mx-3 mt-3 mb-0" role="alert">
                                        <i class=""></i> Data pemesanan tidak ditemukan.
                                    </div>
                                </td>
                            </tr>
                        @endif


                        @foreach ($paginatedPesanan as $index => $pesanan)
                            <tr>
                                <td>{{ $index + 1 + $start }}</td>
                                <td>{{ $pesanan->kode_pesanan }}</td>
                                <td>{{ $pesanan->nama_pemesan }}</td>
                                <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d-m-Y') }}</td>
                                <td>{{ $pesanan->catatan ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary px-4 py-0" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#detail-{{ $pesanan->id_pesanan }}">
                                        <small>Lihat</small>
                                    </button>
                                </td>
                                <td class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.produksi.destroy-pesanan', $pesanan->id_pesanan) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn text-danger p-0 border-0 bg-transparent">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.produksi.edit-pesanan', $pesanan->id_pesanan) }}"
                                        class="text-primary">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Detail Produk -->
                            <tr class="collapse" id="detail-{{ $pesanan->id_pesanan }}">
                                <td colspan="8">
                                    <div class="p-2">
                                        <h6>Produk yang Dipesan:</h6>
                                        <ul class="list-group">
                                            @forelse ($pesanan->detailPesanan as $detail)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}
                                                    <span
                                                        class="badge bg-primary rounded-pill">{{ $detail->jumlah }}</span>
                                                </li>
                                            @empty
                                                <li class="list-group-item text-muted">Tidak ada detail pesanan.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-start mt-3">
                    @php
                        $totalPages = ceil($pesanan->count() / $perPage);
                    @endphp

                    @if ($totalPages > 1)
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <!-- Previous Button -->
                                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="?page={{ $currentPage - 1 }}" tabindex="-1"
                                        aria-disabled="true">&lt;</a>
                                </li>

                                <!-- Page Number Buttons -->
                                @for ($i = 1; $i <= $totalPages; $i++)
                                    <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Next Button -->
                                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                    <a class="page-link" href="?page={{ $currentPage + 1 }}">&gt;</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>

            </div>
        </div>
    </div>

@endsection
