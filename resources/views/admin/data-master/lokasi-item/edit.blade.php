@extends('layout.layout')
@section('title', 'Edit Lokasi')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header">Edit Lokasi</h5>
            <div class="card-body">
                <form action="{{ route('admin.lokasi.update', $lokasi->id_lokasi) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                        <input type="text" class="form-control @error('nama_lokasi') is-invalid @enderror" id="nama_lokasi"
                            name="nama_lokasi" value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}" required>
                        @error('nama_lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.lokasi.item-lokasi') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

@endsection
