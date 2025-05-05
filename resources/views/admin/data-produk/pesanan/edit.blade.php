@extends('layout.layout')
@section('title', 'Edit Pemesanan')
@section('content')

<div class="container mt-4">
    <form action="{{ route('admin.produksi.update', $pesanan->id_pesanan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- KIRI: Info Pemesanan -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <h5 class="card-header">Informasi Pemesanan</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kode_pesanan" class="form-label">Kode Pemesanan</label>
                            <input type="text" class="form-control @error('kode_pesanan') is-invalid @enderror"
                                id="kode_pesanan" name="kode_pesanan" value="{{ old('kode_pesanan', $pesanan->kode_pesanan) }}" required>
                            @error('kode_pesanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pesanan" class="form-label">Tanggal Pemesanan</label>
                            <input type="date" class="form-control @error('tanggal_pesanan') is-invalid @enderror"
                                id="tanggal_pesanan" name="tanggal_pesanan" value="{{ old('tanggal_pesanan', $pesanan->tanggal_pesanan) }}" required>
                            @error('tanggal_pesanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                            <input type="text" class="form-control @error('nama_pemesan') is-invalid @enderror"
                                id="nama_pemesan" name="nama_pemesan" value="{{ old('nama_pemesan', $pesanan->nama_pemesan) }}" required>
                            @error('nama_pemesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" name="catatan" rows="3">{{ old('catatan', $pesanan->catatan) }}</textarea>
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
                        @foreach ($pesanan->detailPesanan as $detail)
                            <div class="row mb-3 produk-item">
                                <div class="col-md-5">
                                    <label class="form-label">Produk</label>
                                    <select name="produk_id[]" class="form-select" required>
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach ($produk as $item)
                                            <option value="{{ $item->id_produk }}" 
                                                {{ $item->id_produk == $detail->produk->id_produk ? 'selected' : '' }}>
                                                {{ $item->nama_produk }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="jumlah[]" class="form-control" value="{{ old('jumlah.' . $loop->index, $detail->jumlah) }}" required min="1">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-produk w-100">Hapus</button>
                                </div>
                            </div>
                        @endforeach
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

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tambahBtn = document.getElementById('tambah-produk');
    const produkWrapper = document.getElementById('produk-wrapper');

    produkWrapper.classList.add('overflow-auto', 'max-h-96'); // Kelas dari Sneat untuk scrollable

    tambahBtn.addEventListener('click', function () {
        const produkItem = document.createElement('div');
        produkItem.classList.add('row', 'mb-3', 'produk-item');

        produkItem.innerHTML = `
            <div class="col-md-5">
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
                <input type="number" name="jumlah[]" class="form-control" required min="1">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-produk">Hapus</button>
            </div>
        `;

        produkWrapper.appendChild(produkItem);
    });

    produkWrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-produk')) {
            e.target.closest('.produk-item').remove();
        }
    });
});
</script>
@endpush
