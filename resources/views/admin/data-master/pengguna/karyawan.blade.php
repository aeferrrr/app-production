@extends('layout.layout')
@section('title', 'Karyawan')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Data Karyawan
            </h5>

            @if (session('success'))
                <div class="alert alert-success mx-2 mt-2">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                <!-- Filter & Search -->
                <div class="left-header d-flex justify-content-between align-items-center mx-3 mt-3">
                    <form action="{{ route('admin.item-karyawan') }}" class="d-flex gap-2 p-1" method="get">
                        @csrf
                        <select name="role" class="form-select w-auto">
                            <option value="" hidden>Pilih Jabatan</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="karyawan" {{ request('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                        </select>

                        <input type="text" name="search" class="form-control w-auto" placeholder="Cari Karyawan"
                            value="{{ request('search') }}">

                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>

                        @if (request('role') || request('search'))
                            <a href="{{ route('admin.item-karyawan') }}" class="btn btn-sm btn-secondary">Reset</a>
                        @endif
                    </form>

                    <a href="{{ route('admin.karyawan.create') }}" class="btn btn-sm btn-primary ms-auto">
                        <i class="bx bx-plus"></i> Tambah Karyawan
                    </a>
                </div>

                <!-- Not Found Message -->
                @if ($user->isEmpty())
                    <div class="alert alert-warning mx-3 mt-3">
                        Data karyawan tidak ditemukan.
                    </div>
                @else
                    <!-- Tabel Data -->
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Email</th>
                                <th>No. Wa</th>
                                <th class="text-center" style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $index => $pengguna)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pengguna->name }}</td>
                                    <td>{{ ucfirst($pengguna->role) }}</td>
                                    <td>{{ $pengguna->email }}</td>
                                    <td>
                                        @if ($pengguna->no_wa)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengguna->no_wa) }}"
                                                target="_blank">
                                                {{ $pengguna->no_wa }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('admin.karyawan.destroy', $pengguna->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn text-danger p-0 border-0 bg-transparent">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.karyawan.edit', $pengguna->id) }}" class="text-primary">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $user->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
