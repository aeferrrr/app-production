@extends('layout.layout')
@section('title', 'Karyawan')
@section('content')

    <div class="container mt-5">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Data Karyawan
            </h5>
            <div class="table-responsive text-nowrap">
                <!-- Form Filter & Search -->
                <div class="left-header d-flex justify-content-between align-items-center mx-3">
                    <form action="{{ route('admin.item-karyawan') }}" class="d-flex gap-2 p-1" method="get">
                        @csrf
                        <select name="role" class="form-select w-auto">
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="karyawan" {{ request('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                        </select>
                        <input type="text" name="search" class="form-control w-auto" placeholder="Cari Karyawan"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    </form>
                    <a href="#" class="btn btn-sm btn-primary ms-auto">
                        <i class="bx bx-plus"></i> Tambah Karyawan
                    </a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th style="width: 100px; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengguna as $index => $pengguna)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pengguna->name }}</td>
                                <td>{{ ucfirst($pengguna->role) }}</td>
                                <td>{{ $pengguna->email }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="#" class="text-danger"><i class="bx bx-trash"></i></a>
                                    <a href="#" class="text-primary"><i class="bx bx-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination ms-2">
                    @php
                        use App\Models\User;
                        $pengguna = User::query();
                        $pengguna = $pengguna->paginate(5);
                    @endphp
                    {{ $pengguna->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

@endsection
