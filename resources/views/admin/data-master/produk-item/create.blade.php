@extends('layout.layout')
@section('title', 'Tambah Produk')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header">Tambah Produk</h5>
            <div class="card-body">
                <form action="{{ route('admin.produk.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="kode_produk" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control @error('kode_produk') is-invalid @enderror"
                            id="kode_produk" name="kode_produk" value="{{ old('kode_produk') }}">
                        @error('kode_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                            id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}">
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                            value="{{ old('harga_jual', isset($produk) ? $produk->harga_jual : '') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah Produk</button>
                    <a href="{{ route('admin.produk.item-produk') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

@endsection
