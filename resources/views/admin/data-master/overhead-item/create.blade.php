@extends('layout.layout')
@section('title', 'Tambah Overhead')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <h5 class="card-header">Tambah Overhead</h5>
            <div class="card-body">
                <form action="{{ route('admin.overhead.store') }}" method="POST">
                    @csrf

                    <!-- Input Nama Overhead -->
                    <div class="mb-3">
                        <label class="form-label">Nama Overhead</label>
                        <input type="text" name="nama_bop" class="form-control @error('nama_bop') is-invalid @enderror"
                            value="{{ old('nama_bop') }}" required>
                        @error('nama_bop')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Biaya Overhead -->
                    <div class="mb-3">
                        <label class="form-label">Biaya (Rp)</label>
                        <input type="number" name="biaya_bop" class="form-control @error('biaya_bop') is-invalid @enderror"
                            value="{{ old('biaya_bop') }}" required>
                        @error('biaya_bop')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Keterangan -->
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan_bop" class="form-control @error('keterangan_bop') is-invalid @enderror" rows="3">{{ old('keterangan_bop') }}</textarea>
                        @error('keterangan_bop')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah Overhead</button>
                    <a href="{{ route('admin.overhead.item-overhead') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
