@extends('layout.layout')
@section('title', 'Tambah Lokasi')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <h5 class="card-header">Tambah Lokasi</h5>
            <div class="card-body">
                <form action="{{ route('admin.lokasi.store') }}" method="POST">
                    @csrf

                    <!-- Input Nama Lokasi -->
                    <div class="mb-3">
                        <label class="form-label">Nama Lokasi</label>
                        <input type="text" name="nama_lokasi" class="form-control @error('nama_lokasi') is-invalid @enderror"
                            value="{{ old('nama_lokasi') }}" required>
                        @error('nama_lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah Lokasi</button>
                    <a href="{{ route('admin.lokasi.item-lokasi') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
