@extends('layout.layout')
@section('title', 'Produk')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Data Produk
            </h5>
            @if (session('success'))
                <div class="alert alert-success mx-2">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                <!-- Form Filter & Search -->
                <div class="left-header d-flex justify-content-between align-items-center mx-3">
                    <form action="{{ route('admin.produk.index') }}" class="d-flex gap-2 p-1" method="get">
                        @csrf
                        <input type="text" name="search" class="form-control w-auto" placeholder="Cari Produk"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                    </form>
                    <a href="{{ route('admin.produk.create') }}" class="btn btn-sm btn-primary ms-auto">
                        <i class="bx bx-plus"></i> Tambah Produk
                    </a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th style="width: 100px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kode_produk }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.produk.destroy', $item->id_produk) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn text-danger p-0 border-0 bg-transparent">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.produk.edit', $item->id_produk) }}" class="text-primary"><i
                                            class="bx bx-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination mt-3 ms-2">
                    {{ $produk->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

@endsection
