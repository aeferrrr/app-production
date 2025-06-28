@extends('layout.layout')
@section('title', 'Produksi')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Data Produksi (Produk & Bahan)
            </h5>

            @if (session('success'))
                <div class="alert alert-success mx-2">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                <div class="left-header d-flex justify-content-between align-items-center mx-3 mt-2">
                    <form action="{{ route('admin.produksi.item-produksi') }}" class="d-flex gap-2 p-1" method="get">
                        <input type="text" name="search" class="form-control w-auto" placeholder="Cari Produk"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                        @if (request('search'))
                            <a href="{{ route('admin.produksi.item-produksi') }}" class="btn btn-sm btn-secondary">Reset</a>
                        @endif
                    </form>
                    <a href="{{ route('admin.produksi.create') }}" class="btn btn-sm btn-primary ms-auto">
                        <i class="bx bx-plus"></i> Tambah Produk Bahan
                    </a>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah Bahan Dipakai</th>
                            <th style="width: 100px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($paginatedGrouped->isEmpty())
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-warning mx-3 mt-3 mb-0" role="alert">
                                        <i class=""></i> Data produk bahan tidak ditemukan.
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($paginatedGrouped as $items)
                                @php
                                    $produk = $items->first()->produk;
                                    $produkId = $produk->id_produk;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration + ($paginatedGrouped->currentPage() - 1) * $paginatedGrouped->perPage() }}
                                    </td>
                                    <td>{{ $produk->nama_produk }}</td>
                                    <td>{{ $items->count() }}</td>
                                    <td class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-link text-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalBahan{{ $produkId }}">
                                            Lihat Bahan
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                {{-- PAGINATION --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $paginatedGrouped->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL LIHAT, TAMBAH, & EDIT BAHAN --}}
    @foreach ($paginatedGrouped as $items)
        @php
            $produk = $items->first()->produk;
            $produkId = $produk->id_produk;
        @endphp

        {{-- Modal Lihat Bahan --}}
        <div class="modal fade" id="modalBahan{{ $produkId }}" tabindex="-1"
            aria-labelledby="modalBahanLabel{{ $produkId }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h5 class="modal-title mb-0" id="modalBahanLabel{{ $produkId }}">
                                Bahan untuk Produk: {{ $produk->nama_produk }}
                            </h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#tambahBahanModal{{ $produkId }}">
                                <i class="bx bx-plus"></i> Tambah Bahan
                            </button>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                        <ul class="list-group">
                            @foreach ($items as $produkBahanItem)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <strong>{{ $produkBahanItem->bahan->nama_bahan ?? 'Tidak ada bahan' }}</strong><br>
                                        Jumlah: {{ $produkBahanItem->jumlah_bahan ?? '-' }}<br>
                                        Satuan: {{ $produkBahanItem->satuan ?? '-' }}
                                    </span>
                                    <div class="d-flex gap-2">
                                        {{-- Edit Modal Trigger --}}
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModalBahan{{ $produkBahanItem->id_produk_bahan }}">
                                            Edit
                                        </button>
                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('admin.produksi.destroy', $produkBahanItem->id_produk_bahan) }}"
                                            method="POST" class="mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <form action="{{ route('admin.produksi.destroyAllBahan') }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus semua bahan untuk produk ini?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id_produk" value="{{ $produkId }}">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Hapus Semua Bahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Tambah Bahan --}}
        <div class="modal fade" id="tambahBahanModal{{ $produkId }}" tabindex="-1"
            aria-labelledby="tambahBahanModalLabel{{ $produkId }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.produksi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_produk" value="{{ $produkId }}">

                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahBahanModalLabel{{ $produkId }}">
                                Tambah Bahan ke Produk: {{ $produk->nama_produk }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div id="bahanContainer">
                                <div class="bahan-group row mb-2 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label">Bahan</label>
                                        <select name="id_bahan[]" class="form-select select-bahan" required>
                                            <option value="">-- Pilih Bahan --</option>
                                            @foreach ($allBahan as $bahan)
                                                <option value="{{ $bahan->id_bahan }}">{{ $bahan->nama_bahan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Jumlah</label>
                                        <input type="number" name="jumlah_bahan[]" class="form-control"
                                            placeholder="Masukkan jumlah" required min="0">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Satuan</label>
                                        <input type="text" name="satuan[]" class="form-control"
                                            placeholder="Contoh: gram" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-sm btn-danger remove-bahan">Hapus</button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-success mt-2 tambahBaris">
                                + Tambah Bahan Lagi
                            </button>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Edit per Bahan --}}
        @foreach ($items as $produkBahanItem)
            <div class="modal fade" id="editModalBahan{{ $produkBahanItem->id_produk_bahan }}" tabindex="-1"
                aria-labelledby="editModalBahanLabel{{ $produkBahanItem->id_produk_bahan }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('admin.produksi.update', $produkBahanItem->id_produk_bahan) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id_produk_bahan"
                                value="{{ $produkBahanItem->id_produk_bahan }}">

                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalBahanLabel{{ $produkBahanItem->id_produk_bahan }}">
                                    Edit Bahan untuk Produk: {{ $produkBahanItem->produk->nama_produk }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Bahan</label>
                                    <select name="id_bahan" class="form-select select-bahan" required>
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach ($allBahan as $bahan)
                                            <option value="{{ $bahan->id_bahan }}"
                                                {{ $bahan->id_bahan == $produkBahanItem->id_bahan ? 'selected' : '' }}>
                                                {{ $bahan->nama_bahan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="jumlah_bahan" class="form-control"
                                        value="{{ $produkBahanItem->jumlah_bahan }}" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" name="satuan" class="form-control"
                                        value="{{ $produkBahanItem->satuan }}" required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        {{-- Kirim data bahan dari Blade ke JS --}}
        <script>
            window.allBahan = @json($allBahan); // Kirim ke global scope JS
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                // Saat modal dibuka, inisialisasi Select2 di dalamnya
                $(document).on('shown.bs.modal', '.modal', function() {
                    const modal = $(this);
                    modal.find('select.select-bahan').each(function() {
                        if (!$(this).hasClass("select2-hidden-accessible")) {
                            $(this).select2({
                                width: '100%',
                                placeholder: "-- Pilih Bahan --",
                                allowClear: true,
                                dropdownParent: modal
                            });
                        }
                    });
                });

                // ✅ Tombol Tambah Baris Bahan (menghindari cloning select kosong)
                $(document).on('click', '.tambahBaris', function() {
                    const modal = $(this).closest('.modal');
                    const container = modal.find('#bahanContainer');

                    // Generate <option> dari allBahan (data global)
                    let options = '<option value="">-- Pilih Bahan --</option>';
                    window.allBahan.forEach(function(bahan) {
                        options += `<option value="${bahan.id_bahan}">${bahan.nama_bahan}</option>`;
                    });

                    // Template baris baru
                    const newGroup = $(`
                <div class="bahan-group row mb-2">
                    <div class="col-md-4">
                        <select name="id_bahan[]" class="form-select select-bahan" required>
                            ${options}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="jumlah_bahan[]" class="form-control" required min="0">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="satuan[]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-sm btn-danger remove-bahan">Hapus</button>
                    </div>
                </div>
            `);

                    // Tambahkan ke container
                    container.append(newGroup);

                    // Inisialisasi Select2 untuk elemen baru
                    newGroup.find('select.select-bahan').select2({
                        width: '100%',
                        placeholder: "-- Pilih Bahan --",
                        allowClear: true,
                        dropdownParent: modal
                    });
                });

                // Tombol Hapus baris bahan
                $(document).on('click', '.remove-bahan', function() {
                    const container = $(this).closest('#bahanContainer');
                    if (container.find('.bahan-group').length > 1) {
                        $(this).closest('.bahan-group').remove();
                    }
                });
            });
        </script>
    @endpush

@endsection
