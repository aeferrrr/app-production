@extends('layout.layout')
@section('title', 'Edit Overhead')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header">Edit Overhead</h5>
            <div class="card-body">
                <form action="{{ route('admin.overhead.update', $overhead->id_bop) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_bop" class="form-label">Nama Overhead</label>
                        <input type="text" class="form-control @error('nama_bop') is-invalid @enderror" id="nama_bop"
                            name="nama_bop" value="{{ old('nama_bop', $overhead->nama_bop) }}" required>
                        @error('nama_bop')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="biaya_bop" class="form-label">Biaya (Rp)</label>
                        <input type="number" class="form-control @error('biaya_bop') is-invalid @enderror" id="biaya_bop"
                            name="biaya_bop" value="{{ old('biaya_bop', $overhead->biaya_bop) }}" required>
                        @error('biaya_bop')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan_bop" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan_bop') is-invalid @enderror" id="keterangan_bop" name="keterangan_bop"
                            rows="3" required>{{ old('keterangan_bop', $overhead->keterangan_bop) }}</textarea>
                        @error('keterangan_bop')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.overhead.item-overhead') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

@endsection
