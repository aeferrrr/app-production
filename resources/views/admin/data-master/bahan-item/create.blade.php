@extends('layout.layout')
@section('title', 'Tambah Bahan')

@section('content')
<div class="container mt-4">
    <div class="card">
        <h5 class="card-header">Tambah Bahan</h5>
        <div class="card-body">
            <form action="{{ route('admin.bahan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="kode_bahan" class="form-label">Kode Bahan</label>
                    <input type="text" name="kode_bahan" id="kode_bahan" 
                        class="form-control @error('kode_bahan') is-invalid @enderror" 
                        value="{{ old('kode_bahan') }}">
                    @error('kode_bahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_bahan" class="form-label">Nama Bahan</label>
                    <input type="text" name="nama_bahan" id="nama_bahan" 
                        class="form-control @error('nama_bahan') is-invalid @enderror" 
                        value="{{ old('nama_bahan') }}">
                    @error('nama_bahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="harga_bahan" class="form-label">Harga Bahan</label>
                    <input type="number" name="harga_bahan" id="harga_bahan" 
                        class="form-control @error('harga_bahan') is-invalid @enderror" 
                        value="{{ old('harga_bahan') }}">
                    @error('harga_bahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" name="satuan" id="satuan" 
                        class="form-control @error('satuan') is-invalid @enderror" 
                        value="{{ old('satuan') }}">
                    @error('satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.bahan.item-bahan') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
