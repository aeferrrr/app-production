@extends('layout.layout')
@section('title', 'Edit Penjadwalan Produksi')
@section('content')

    <div class="container mt-4">
        <form action="{{ route('admin.produksi.update-penjadwalan', $jadwal->id_jadwal) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- KIRI -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <h5 class="card-header">Informasi Penjadwalan</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Pilih Pesanan</label>
                                <select name="id_pesanan" class="form-select" required>
                                    <option value="">-- Pilih Kode Pesanan --</option>
                                    @foreach ($pesanan as $item)
                                        <option value="{{ $item->id_pesanan }}"
                                            {{ $item->id_pesanan == $jadwal->id_pesanan ? 'selected' : '' }}>
                                            {{ $item->kode_pesanan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_pesanan')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai Produksi</label>
                                <input type="date" name="tanggal_mulai" class="form-control"
                                    value="{{ $jadwal->tanggal_mulai }}" required>
                                @error('tanggal_mulai')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai Produksi</label>
                                <input type="date" name="tanggal_selesai" class="form-control"
                                    value="{{ $jadwal->tanggal_selesai }}" required>
                                @error('tanggal_selesai')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status_jadwal" class="form-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="menunggu" {{ $jadwal->status_jadwal == 'menunggu' ? 'selected' : '' }}>
                                        Menunggu</option>
                                    <option value="berjalan" {{ $jadwal->status_jadwal == 'berjalan' ? 'selected' : '' }}>
                                        Diproses</option>
                                    <option value="selesai" {{ $jadwal->status_jadwal == 'selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @error('status_jadwal')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- KANAN -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <h5 class="card-header d-flex justify-content-between align-items-center">
                            Petugas Produksi
                            <button type="button" class="btn btn-sm btn-outline-primary" id="tambah-petugas">
                                <i class="bx bx-plus"></i> Tambah Petugas
                            </button>
                        </h5>
                        <div class="card-body" id="petugas-wrapper">
                            @foreach ($jadwal->users as $index => $petugas)
                                <div class="row mb-3 petugas-item">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Petugas</label>
                                        <select name="user_id[]" class="form-select" required>
                                            <option value="">-- Pilih Petugas --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $user->id == $petugas->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id.' . $index)
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Upah</label>
                                        <input type="number" name="upah[]" class="form-control" min="0"
                                            value="{{ $petugas->pivot->upah }}" required>
                                        @error('upah.' . $index)
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button"
                                            class="btn btn-danger btn-sm remove-petugas w-100">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update Jadwal</button>
                        <a href="{{ route('admin.produksi.item-penjadwalan') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tambahBtn = document.getElementById('tambah-petugas');
            const petugasWrapper = document.getElementById('petugas-wrapper');

            tambahBtn.addEventListener('click', function() {
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

            petugasWrapper.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-petugas')) {
                    e.target.closest('.petugas-item').remove();
                }
            });
        });
    </script>
@endpush
