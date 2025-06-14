@extends('layout.layout')
@section('title', 'Perhitungan HPP')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header">Perhitungan Harga Pokok Produksi (HPP)</h5>
            <div class="card-body">
                <form action="{{ route('admin.produksi.hpp') }}" method="GET" class="row g-3">
                    <div class="col-md-6">
                        <label for="pesanan_id" class="form-label">Kode Pesanan</label>
                        <select name="pesanan_id" id="pesanan_id" class="form-select" required>
                            <option value="">-- Pilih Kode Pesanan --</option>
                            @foreach ($pesanan as $item)
                                <option value="{{ $item->id_pesanan }}"
                                    {{ request('pesanan_id') == $item->id_pesanan ? 'selected' : '' }}>
                                    {{ $item->kode_pesanan }} - {{ $item->tanggal_pesanan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="btk" class="form-label">BTK Total</label>
                        <input type="number" name="btk" id="btk" class="form-control"
                            value="{{ request('btk') ?? 0 }}" min="0" required>
                    </div>

                    <div class="col-md-3">
                        <label for="bop" class="form-label">BOP Total</label>
                        <input type="number" name="bop" id="bop" class="form-control"
                            value="{{ request('bop') ?? 0 }}" min="0" required>
                    </div>

                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-calculator"></i> Hitung
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if ($hppData)
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-3">HPP untuk Kode Pesanan:
                        <span class="badge bg-primary">{{ $selectedPesanan->kode_pesanan }}</span>
                        <small class="text-muted">({{ $totalJumlah }} unit total)</small>
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr class="text-center fw-bold">
                                    <th style="width: 20%">Jenis</th>
                                    <th>Rincian</th>
                                    <th style="width: 20%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- BBB --}}
                                <tr>
                                    <td rowspan="{{ count($hppData['bahan']) + 1 }}" class="align-middle fw-semibold">BBB
                                        (Bahan Baku)</td>
                                </tr>
                                @foreach ($hppData['bahan'] as $bahan)
                                    <tr>
                                        <td>
                                            {{ $bahan['nama'] }} ({{ $bahan['jumlah'] }} {{ $bahan['satuan'] }}) ×
                                            <span class="text-success">Rp
                                                {{ number_format($bahan['harga'], 0, ',', '.') }}</span>
                                        </td>
                                        <td class="text-end">Rp {{ number_format($bahan['subtotal'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr class="table-light fw-bold">
                                    <td>Total BBB</td>
                                    <td>Biaya total bahan baku untuk pesanan ini</td>
                                    <td class="text-end">Rp {{ number_format($hppData['totalBBB'], 0, ',', '.') }}</td>
                                </tr>

                                {{-- BTK --}}
                                <tr class="fw-semibold">
                                    <td>BTK (Tenaga Kerja)</td>
                                    <td>Input manual oleh user atau dari jadwal produksi</td>
                                    <td class="text-end">Rp {{ number_format($hppData['totalBTK'], 0, ',', '.') }}</td>
                                </tr>

                                {{-- BOP --}}
                                <tr class="fw-semibold">
                                    <td>BOP (Overhead)</td>
                                    <td>Input manual oleh user</td>
                                    <td class="text-end">Rp {{ number_format($hppData['totalBOP'], 0, ',', '.') }}</td>
                                </tr>

                                {{-- Total HPP --}}
                                <tr class="table-primary fw-bold">
                                    <td>HPP Total</td>
                                    <td colspan="2" class="text-end">Rp
                                        {{ number_format($hppData['totalHPP'], 0, ',', '.') }}</td>
                                </tr>

                                {{-- HPP per Unit --}}
                                <tr class="table-success fw-bold">
                                    <td>HPP per Unit</td>
                                    <td colspan="2" class="text-end">Rp
                                        {{ number_format($hppData['hppPerUnit'], 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Faktur & Laba Kotor --}}
            @if ($fakturData)
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="mb-3">Faktur Penjualan & Laba Kotor</h5>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr class="text-center fw-bold">
                                        <th>Deskripsi</th>
                                        <th class="text-end">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Pendapatan</td>
                                        <td class="text-end text-success">Rp
                                            {{ number_format($fakturData['totalPendapatan'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Laba Kotor</td>
                                        <td class="text-end text-primary">Rp
                                            {{ number_format($fakturData['labaKotor'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Margin Laba (%)</td>
                                        <td class="text-end">{{ number_format($fakturData['marginPersen'], 2, ',', '.') }}%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <p class="text-muted mt-3">
                            <i class="fas fa-info-circle"></i> Laba kotor = Total Pendapatan - Total HPP. Margin menunjukkan
                            persentase keuntungan dari penjualan.
                        </p>
                    </div>
                </div>
            @endif

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-3">Detail Produk dalam Pesanan</h5>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-light">
                                <tr class="text-center fw-bold">
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga Jual (per unit)</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selectedPesanan->detailPesanan as $item)
                                    <tr>
                                        <td>{{ $item->produk->nama_produk }}</td>
                                        <td class="text-center">{{ $item->jumlah }}</td>
                                        <td class="text-end">Rp
                                            {{ number_format($item->produk->harga_jual ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end">
                                            Rp
                                            {{ number_format(($item->produk->harga_jual ?? 0) * $item->jumlah, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        w
                    </div>
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('admin.produksi.admin.produksi.hpp.pdf', ['pesanan_id' => request('pesanan_id'), 'btk' => request('btk'), 'bop' => request('bop')]) }}"
                    target="_blank" class="btn btn-outline-danger">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a>
            </div>

        @endif
    </div>
@endsection
