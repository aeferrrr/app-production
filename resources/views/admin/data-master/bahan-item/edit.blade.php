@extends('layout.layout')
@section('title', 'Edit Bahan')

@section('content')
<div class="container mt-4">
    <div class="card">
        <h5 class="card-header">Edit Bahan</h5>
        <div class="card-body">
            <form action="{{ route('admin.bahan.update', $bahan->id_bahan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="kode_bahan" class="form-label">Kode Bahan</label>
                    <input type="text" name="kode_bahan" id="kode_bahan" class="form-control" value="{{ $bahan->kode_bahan }}" required>
                </div>

                <div class="mb-3">
                    <label for="nama_bahan" class="form-label">Nama Bahan</label>
                    <input type="text" name="nama_bahan" id="nama_bahan" class="form-control" value="{{ $bahan->nama_bahan }}" required>
                </div>

                <div class="mb-3">
                    <label for="harga_bahan" class="form-label">Harga Bahan</label>
                    <input type="number" name="harga_bahan" id="harga_bahan" class="form-control" value="{{ $bahan->harga_bahan }}" required>
                </div>

                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" name="satuan" id="satuan" class="form-control" value="{{ $bahan->satuan }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.bahan.item-bahan') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
