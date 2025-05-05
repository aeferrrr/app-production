@extends('layout.layout')
@section('title', 'Overhead')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Data Overhead
            </h5>
            @if (session('success'))
                <div class="alert alert-success mx-2">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                <!-- Form Filter & Search -->
                <div class="left-header d-flex justify-content-between align-items-center mx-3">
                    <form action="{{ route('admin.item-karyawan') }}" class="d-flex gap-2 p-1" method="get">
                        @csrf
                        <input type="text" name="search" class="form-control w-auto" placeholder="Cari Overhead"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    </form>
                    <a href="{{ route('admin.overhead.create') }}" class="btn btn-sm btn-primary ms-auto">
                        <i class="bx bx-plus"></i> Tambah Overhead
                    </a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Biaya</th>
                            <th>Keterangan</th>
                            <th style="width: 100px; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bop as $index => $overhead)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $overhead->nama_bop }}</td>
                                <td>{{ 'Rp ' . number_format($overhead->biaya_bop, 0, ',', '.') }}</td> <!-- Format Rupiah -->
                                <td>{{ $overhead->keterangan_bop }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.overhead.destroy', $overhead->id_bop) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn text-danger p-0 border-0 bg-transparent">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.overhead.edit', $overhead->id_bop) }}" class="text-primary"><i
                                            class="bx bx-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination mt-3 ms-2">
                    @php
                        use App\Models\User;
                        $overhead = User::query();
                        $overhead = $overhead->paginate(5);
                    @endphp
                    {{ $overhead->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

@endsection
