@extends('layout.layout')
@section('title', 'Tambah Pemesanan')
@section('content')

<div class="container mt-4">
    <form action="{{ route('admin.produksi.store-pesanan') }}" method="POST">
        @csrf
        <div class="row">
            <!-- KIRI: Info Pemesanan -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <h5 class="card-header">Informasi Pemesanan</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kode_pesanan" class="form-label">Kode Pemesanan</label>
                            <input type="text" class="form-control @error('kode_pesanan') is-invalid @enderror"
                                id="kode_pesanan" name="kode_pesanan" value="{{ old('kode_pesanan') }}" readonly>
                            @error('kode_pesanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pesanan" class="form-label">Tanggal Pemesanan</label>
                            <input type="date" class="form-control @error('tanggal_pesanan') is-invalid @enderror"
                                id="tanggal_pesanan" name="tanggal_pesanan" value="{{ old('tanggal_pesanan') }}" required>
                            @error('tanggal_pesanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                            <input type="text" class="form-control @error('nama_pemesan') is-invalid @enderror"
                                id="nama_pemesan" name="nama_pemesan" value="{{ old('nama_pemesan') }}" required>
                            @error('nama_pemesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KANAN: Detail Produk -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        Produk Dipesan
                        <button type="button" class="btn btn-sm btn-outline-primary" id="tambah-produk">
                            <i class="bx bx-plus"></i> Tambah Produk
                        </button>
                    </h5>
                    <div class="card-body" id="produk-wrapper">
                        <div class="row mb-3 produk-item">
                            <div class="col-md-6">
                                <label class="form-label">Produk</label>
                                <select name="produk_id[]" class="form-select" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($produk as $item)
                                        <option value="{{ $item->id_produk }}">{{ $item->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah[]" class="form-control" min="1" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-produk w-100">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Pemesanan</button>
                    <a href="{{ route('admin.produksi.item-pesanan') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </form>
</div>
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tambahBtn = document.getElementById('tambah-produk');
    const produkWrapper = document.getElementById('produk-wrapper');

    // Scrollable class ala Sneat
    produkWrapper.classList.add('overflow-auto', 'max-h-96', 'px-2');

    // Inisialisasi Select2
    function initSelect2() {
        $(produkWrapper).find('.form-select').select2({
            width: '100%',
            dropdownParent: $('#produk-wrapper')
        });
    }

    initSelect2();

    tambahBtn.addEventListener('click', function () {
        const produkItem = document.createElement('div');
        produkItem.classList.add('row', 'g-3', 'mb-3', 'produk-item');

        produkItem.innerHTML = `
            <div class="col-md-6">
                <label class="form-label">Produk</label>
                <select name="produk_id[]" class="form-select" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($produk as $item)
                        <option value="{{ $item->id_produk }}">{{ $item->nama_produk }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah[]" class="form-control" required min="1" placeholder="Contoh: 2">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-produk">
                    <i class="bx bx-trash"></i> Hapus
                </button>
            </div>
        `;

        produkWrapper.appendChild(produkItem);
        initSelect2(); // Inisialisasi select2 ulang
    });

    produkWrapper.addEventListener('click', function (e) {
        if (e.target.closest('.remove-produk')) {
            e.target.closest('.produk-item').remove();
        }
    });
});
</script>
@endpush
@endsection