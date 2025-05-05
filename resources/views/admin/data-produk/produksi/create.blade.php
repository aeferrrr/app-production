@extends('layout.layout')
@section('title', 'Tambah Produksi Bahan')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <h5 class="card-header">Tambah Produksi Bahan</h5>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('admin.produksi.store') }}" method="POST">
                    @csrf

                    <!-- Input Produk -->
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <select name="id_produk" class="form-select @error('id_produk') is-invalid @enderror" required>
                            <option value="">Pilih Produk</option>
                            @foreach ($produk as $item)
                                <option value="{{ $item->id_produk }}"
                                    {{ old('id_produk') == $item->id_produk ? 'selected' : '' }}>
                                    {{ $item->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Bahan -->
                    <div class="mb-3">
                        <label class="form-label">Nama Bahan</label>
                        <select name="id_bahan" class="form-select @error('id_bahan') is-invalid @enderror" required>
                            <option value="">Pilih Bahan</option>
                            @foreach ($bahan as $item)
                                <option value="{{ $item->id_bahan }}"
                                    {{ old('id_bahan') == $item->id_bahan ? 'selected' : '' }}>
                                    {{ $item->nama_bahan }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_bahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Jumlah -->
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah_bahan"
                            class="form-control @error('jumlah_bahan') is-invalid @enderror"
                            value="{{ old('jumlah_bahan') }}" required>
                        @error('jumlah_bahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Satuan -->
                    <div class="mb-3">
                        <label class="form-label">Satuan</label>
                        <input type="text" name="satuan" class="form-control @error('satuan') is-invalid @enderror"
                            value="{{ old('satuan') }}" required>
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah Produksi Bahan</button>
                    <a href="{{ route('admin.produksi.item-produksi') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
