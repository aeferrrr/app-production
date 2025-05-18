@extends('layout.layout')
@section('title', 'Produksi')
@section('content')

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
                        @if ($produkGrouped->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="alert alert-warning mt-3 mb-0" role="alert">
                                        <i class="bx bx-info-circle"></i> Produk tidak ditemukan.
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($produkGrouped as $produkId => $items)
                                @php
                                    $produk = $items->first()->produk;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $produk->nama_produk }}</td>
                                    <td>{{ $items->count() }}</td>
                                    <td class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-link text-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalBahan{{ $produk->id_produk }}">
                                            Lihat Bahan
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {{-- MODAL LIHAT BAHAN, TAMBAH BAHAN & EDIT --}}
    @foreach ($produkGrouped as $produkId => $items)
        {{-- Modal Lihat Bahan --}}
        <div class="modal fade" id="modalBahan{{ $produkId }}" tabindex="-1"
            aria-labelledby="modalBahanLabel{{ $produkId }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h5 class="modal-title mb-0" id="modalBahanLabel{{ $produkId }}">
                                Bahan untuk Produk: {{ $items->first()->produk->nama_produk }}
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
                                Tambah Bahan ke Produk: {{ $items->first()->produk->nama_produk }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Pilih Bahan</label>
                                <select name="id_bahan" class="form-select" required>
                                    <option value="">-- Pilih Bahan --</option>
                                    @foreach ($allBahan as $bahan)
                                        <option value="{{ $bahan->id_bahan }}">{{ $bahan->nama_bahan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah_bahan" class="form-control" required min="0">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Satuan</label>
                                <input type="text" name="satuan" class="form-control" required>
                            </div>
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
                                    <select name="id_bahan" class="form-select" required>
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach ($allBahan as $bahan)
                                            <option value="{{ $bahan->id_bahan }}"
                                                @if ($produkBahanItem->id_bahan == $bahan->id_bahan) selected @endif>
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
@endsection
