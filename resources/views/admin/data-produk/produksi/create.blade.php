@extends('layout.layout')
@section('title', 'Tambah Produksi Bahan')

@section('content')
<div class="container mt-5">
    <div class="card">
        <h5 class="card-header">Tambah Produksi Bahan</h5>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('admin.produksi.store') }}" method="POST">
                @csrf

                <!-- Pilih Produk -->
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <select name="id_produk" class="form-select select-search @error('id_produk') is-invalid @enderror" required>
                        <option value="">Pilih Produk</option>
                        @foreach ($produk as $item)
                            <option value="{{ $item->id_produk }}" {{ old('id_produk') == $item->id_produk ? 'selected' : '' }}>
                                {{ $item->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Wrapper Bahan -->
                <div id="bahan-wrapper">
                    <div class="row bahan-item mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Bahan</label>
                            <select name="id_bahan[]" class="form-select select-search" required>
                                <option value="">Pilih Bahan</option>
                                @foreach ($bahan->sortBy('nama_bahan') as $item)
                                    <option value="{{ $item->id_bahan }}">{{ $item->nama_bahan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah_bahan[]" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="satuan[]" class="form-control" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-remove">×</button>
                        </div>
                    </div>
                </div>

                <!-- Tombol tambah baris bahan -->
                <button type="button" class="btn btn-sm btn-secondary mb-3" id="add-bahan">+ Tambah Bahan</button>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.produksi.item-produksi') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            function initSelect2() {
                $('.select-search').select2({
                    placeholder: "Pilih item",
                    width: '100%'
                });
            }

            initSelect2();

            $('#add-bahan').on('click', function () {
                let html = `
                    <div class="row bahan-item mb-3">
                        <div class="col-md-5">
                            <select name="id_bahan[]" class="form-select select-search" required>
                                <option value="">Pilih Bahan</option>
                                @foreach ($bahan->sortBy('nama_bahan') as $item)
                                    <option value="{{ $item->id_bahan }}">{{ $item->nama_bahan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="jumlah_bahan[]" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="satuan[]" class="form-control" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-remove">×</button>
                        </div>
                    </div>
                `;
                $('#bahan-wrapper').append(html);
                initSelect2();
            });

            // Hapus row bahan
            $(document).on('click', '.btn-remove', function () {
                $(this).closest('.bahan-item').remove();
            });
        });
    </script>
@endpush
