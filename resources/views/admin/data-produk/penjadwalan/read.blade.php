
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
                    <form action="{{ route('admin.produksi.item-pesanan') }}" class="d-flex gap-2 p-1" method="get">
                        @csrf
                        <input type="text" name="search" class="form-control w-auto" placeholder="Cari Pemesanan"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                    </form>
                    <a href="{{ route('admin.produksi.create-penjadwalan') }}" class="btn btn-sm btn-primary ms-auto">
                        <i class="bx bx-plus"></i> Tambah Penjadwalan
                    </a>
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
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')">
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
            </div>
        </div>
    </div>

@endsection
