@extends('layout.layout')
@section('title', 'Penjadwalan Produksi')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Data Penjadwalan Produksi
            </h5>

            @if (session('success'))
                <div class="alert alert-success mx-3 mt-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                <!-- Form Filter & Search -->
                <div class="left-header d-flex justify-content-between align-items-center mx-3 my-3">
                    <form action="{{ route('admin.produksi.item-penjadwalan') }}"
                        class="d-flex flex-wrap gap-2 align-items-end" method="get">
                        <div>
                            <label class="form-label mb-0"><small>Kode Pesanan</small></label>
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Cari Kode" value="{{ request('search') }}">
                        </div>
                        <div>
                            <label class="form-label mb-0"><small>Tanggal Mulai</small></label>
                            <input type="date" name="tanggal_mulai" class="form-control form-control-sm"
                                value="{{ request('tanggal_mulai') }}">
                        </div>
                        <div>
                            <label class="form-label mb-0"><small>Tanggal Selesai</small></label>
                            <input type="date" name="tanggal_selesai" class="form-control form-control-sm"
                                value="{{ request('tanggal_selesai') }}">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-sm btn-primary mt-3">Filter</button>
                            <a href="{{ route('admin.produksi.item-penjadwalan') }}"
                                class="btn btn-sm btn-outline-secondary mt-3">Reset</a>

                        </div>
                    </form>
                    <a href="{{ route('admin.produksi.create-penjadwalan') }}" class="btn btn-sm btn-primary ms-auto">
                        <i class="bx bx-plus"></i> Tambah Penjadwalan
                    </a>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pesanan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th style="width: 120px;">Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjadwalan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->pesanan->kode_pesanan ?? '-' }}</td>
                                <td>{{ $item->tanggal_mulai ?? '-' }}</td>
                                <td>{{ $item->tanggal_selesai ?? '-' }}</td>
                                <td>{{ ucfirst($item->status_jadwal ?? '-') }}</td>
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
                                <td class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.produksi.destroy-penjadwalan', $item->id_jadwal) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus penjadwalan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn text-danger p-0 border-0 bg-transparent">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.produksi.edit-penjadwalan', $item->id_jadwal) }}"
                                        class="text-primary">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Detail Petugas -->
                            @if ($item->users->count())
                                <tr class="collapse" id="petugas-{{ $item->id_jadwal }}">
                                    <td colspan="7">
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
                                <td colspan="7">
                                    <div class="alert alert-warning mx-3 mt-3 mb-0" role="alert">
                                        <i class=""></i> Data penjadwalan tidak ditemukan.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $penjadwalan->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>



            </div>
        </div>
    </div>

@endsection
