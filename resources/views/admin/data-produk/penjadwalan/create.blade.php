@extends('layout.layout')
@section('title', 'Tambah Penjadwalan Produksi')
@section('content')

<div class="container mt-4">
    <form action="{{ route('admin.produksi.store-penjadwalan') }}" method="POST">
        @csrf
        <div class="row">
            <!-- KIRI: Info Jadwal -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <h5 class="card-header">Informasi Penjadwalan</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="id_pesanan" class="form-label">Pilih Pesanan</label>
                            <select name="id_pesanan" class="form-select @error('id_pesanan') is-invalid @enderror" required>
                                <option value="">-- Pilih Kode Pesanan --</option>
                                @foreach ($pesanan as $item)
                                    <option value="{{ $item->id_pesanan }}">{{ $item->kode_pesanan }}</option>
                                @endforeach
                            </select>
                            @error('id_pesanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai Produksi</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                   name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai Produksi</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                   name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_jadwal" class="form-label">Status</label>
                            <select name="status_jadwal" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="berjalan">Diproses</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KANAN: Petugas -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        Petugas Produksi
                        <button type="button" class="btn btn-sm btn-outline-primary" id="tambah-petugas">
                            <i class="bx bx-plus"></i> Tambah Petugas
                        </button>
                    </h5>
                    <div class="card-body" id="petugas-wrapper">
                        <div class="row mb-3 petugas-item">
                            <div class="col-md-6">
                                <label class="form-label">Nama Petugas</label>
                                <select name="user_id[]" class="form-select" required>
                                    <option value="">-- Pilih Petugas --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Upah</label>
                                <input type="number" name="upah[]" class="form-control" min="0" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-petugas w-100">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                    <a href="{{ route('admin.produksi.item-penjadwalan') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tambahBtn = document.getElementById('tambah-petugas');
    const petugasWrapper = document.getElementById('petugas-wrapper');

    petugasWrapper.classList.add('overflow-auto', 'max-h-96');

    tambahBtn.addEventListener('click', function () {
        const petugasItem = document.createElement('div');
        petugasItem.classList.add('row', 'mb-3', 'petugas-item');

        petugasItem.innerHTML = `
            <div class="col-md-6">
                <label class="form-label">Nama Petugas</label>
                <select name="user_id[]" class="form-select" required>
                    <option value="">-- Pilih Petugas --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Upah</label>
                <input type="number" name="upah[]" class="form-control" min="0" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-petugas w-100">Hapus</button>
            </div>
        `;

        petugasWrapper.appendChild(petugasItem);
    });

    petugasWrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-petugas')) {
            e.target.closest('.petugas-item').remove();
        }
    });
});
</script>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi Select2 untuk field Pilih Pesanan
    $('select[name="id_pesanan"]').select2({
        placeholder: "-- Pilih Kode Pesanan --",
        allowClear: true,
        width: '100%',
        dropdownParent: $('select[name="id_pesanan"]').parent()
    });

    // Tambah petugas (ini sudah kamu punya, tinggal dipertahankan)
    const tambahBtn = document.getElementById('tambah-petugas');
    const petugasWrapper = document.getElementById('petugas-wrapper');
    petugasWrapper.classList.add('overflow-auto', 'max-h-96');

    tambahBtn.addEventListener('click', function () {
        const petugasItem = document.createElement('div');
        petugasItem.classList.add('row', 'mb-3', 'petugas-item');

        petugasItem.innerHTML = `
            <div class="col-md-6">
                <label class="form-label">Nama Petugas</label>
                <select name="user_id[]" class="form-select" required>
                    <option value="">-- Pilih Petugas --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Upah</label>
                <input type="number" name="upah[]" class="form-control" min="0" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-petugas w-100">Hapus</button>
            </div>
        `;

        petugasWrapper.appendChild(petugasItem);
    });

    petugasWrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-petugas')) {
            e.target.closest('.petugas-item').remove();
        }
    });
});
</script>
@endpush

@endpush
