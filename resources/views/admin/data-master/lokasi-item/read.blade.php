@extends('layout.layout')
@section('title', 'Lokasi')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Data Lokasi
            </h5>
            @if (session('success'))
                <div class="alert alert-success mx-2">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                <!-- Form Filter & Search -->
                <div class="left-header d-flex justify-content-between align-items-center mx-3">
                    <form action="{{ route('admin.lokasi.item-lokasi') }}" class="d-flex gap-2 p-1" method="get">
                        @csrf
                        <input type="text" name="search" class="form-control w-auto" placeholder="Cari Lokasi"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    </form>
                    <a href="{{ route('admin.lokasi.create') }}" class="btn btn-sm btn-primary ms-auto">
                        <i class="bx bx-plus"></i> Tambah Lokasi
                    </a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lokasi</th>
                            <th style="width: 100px; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lokasi as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_lokasi }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.lokasi.destroy', $item->id_lokasi) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn text-danger p-0 border-0 bg-transparent">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.lokasi.edit', $item->id_lokasi) }}" class="text-primary">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination mt-3 ms-2">
                    {{ $lokasi->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

@endsection
