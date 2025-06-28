@extends('layout.layout')
@section('title', 'Penjadwalan Produksi')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Data Penjadwalan Produksi
            </h5>
            @if (session('success'))
                <div class="alert alert-success mx-2">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive text-nowrap">
                <!-- Form Filter & Search -->
                <div class="left-header d-flex justify-content-between align-items-center mx-3">
                    <form action="{{ route('karyawan.produksi.item-penjadwalan') }}" class="d-flex gap-2 p-1" method="get">
                        @csrf
                        <input type="text" name="search" class="form-control w-auto" placeholder="Cari Pemesanan"
                            value="{{ request('search') }}">

                        <select name="status" class="form-select form-select-sm w-auto">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="berjalan" {{ request('status') == 'berjalan' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>

                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    </form>

                </div>
                {{-- end --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pesanan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th style="width: 120px;">Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjadwalan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->pesanan->kode_pesanan ?? '-' }}</td>
                                <td>{{ $item->tanggal_mulai ?? '-' }}</td>
                                <td>{{ $item->tanggal_selesai ?? '-' }}</td>
                                <td>
                                    <select class="form-select form-select-sm status-dropdown"
                                        data-id="{{ $item->id_jadwal }}">
                                        <option disabled selected>Pilih status</option>
                                        <option value="menunggu"
                                            {{ $item->status_jadwal === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="berjalan"
                                            {{ $item->status_jadwal === 'berjalan' ? 'selected' : '' }}>
                                            Proses</option>
                                        <option value="selesai" {{ $item->status_jadwal === 'selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control catatan-input"
                                            value="{{ $item->pesanan->catatan ?? '' }}"
                                            data-id="{{ $item->pesanan->id_pesanan }}">
                                        <button class="btn btn-success btn-simpan-catatan"
                                            data-id="{{ $item->pesanan->id_pesanan }}">
                                            <i class="bx bx-save"></i>
                                        </button>
                                    </div>
                                </td>



                                <td>
                                    @if (!empty($item->users) && $item->users->count())
                                        <button class="btn btn-sm btn-outline-primary px-4 py-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#petugas-{{ $item->id_jadwal }}">
                                            <small>Lihat</small>
                                        </button>
                                    @else
                                        <em>-</em>
                                    @endif
                                </td>
                            </tr>

                            <!-- Detail Petugas -->
                            @if ($item->users->count())
                                <tr class="collapse" id="petugas-{{ $item->id_jadwal }}">
                                    <td colspan="6">
                                        <div class="p-2">
                                            <h6>Petugas:</h6>
                                            <ul class="list-group">
                                                @foreach ($item->users as $user)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $user->name ?? 'N/A' }}
                                                        @if (isset($user->pivot->upah))
                                                            <span class="badge bg-primary rounded-pill">
                                                                Rp{{ number_format($user->pivot->upah, 0, ',', '.') }}
                                                            </span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data penjadwalan belum ada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $penjadwalan->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropdowns = document.querySelectorAll('.status-dropdown');

                dropdowns.forEach(function(dropdown) {
                    dropdown.addEventListener('change', function() {
                        const selectedStatus = this.value;
                        const jadwalId = this.dataset.id;

                        fetch(`/karyawan/produksi/karyawan-update-status/${jadwalId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    status: selectedStatus
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('✅ Status berhasil diupdate!');
                                } else {
                                    alert('❌ Gagal update status: ' + data.message);
                                }
                            })
                            .catch(error => {
                                alert('❌ Terjadi error: ' + error);
                            });
                    });
                });
            });
        </script>
    @endpush
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const simpanBtns = document.querySelectorAll('.btn-simpan-catatan');

        simpanBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const input = document.querySelector(`.catatan-input[data-id="${id}"]`);
                const catatanValue = input.value.trim();

                fetch(`/karyawan/produksi/update-catatan/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ catatan: catatanValue })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ Catatan berhasil disimpan!');
                    } else {
                        alert('❌ Gagal menyimpan catatan: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('❌ Terjadi error: ' + error);
                });
            });
        });
    });
</script>


@endsection
