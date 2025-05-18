@extends('layout.layout')
@section('title', 'Perhitungan HPP')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header">Perhitungan Harga Pokok Produksi (HPP)</h5>
            <div class="card-body">
                <form action="{{ route('admin.produksi.hpp') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="produk_id" class="form-label">Nama Produk</label>
                        <select name="produk_id" id="produk_id" class="form-select">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($produk as $item)
                                <option value="{{ $item->id_produk }}"
                                    {{ request('produk_id') == $item->id_produk ? 'selected' : '' }}>
                                    {{ $item->kode_produk }} - {{ $item->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control"
                            value="{{ request('jumlah') ?? '' }}" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <label for="btk" class="form-label">BTK Total</label>
                        <input type="number" name="btk" id="btk" class="form-control"
                            value="{{ request('btk') ?? 0 }}" min="0">
                    </div>
                    <div class="col-md-2">
                        <label for="bop" class="form-label">BOP Total</label>
                        <input type="number" name="bop" id="bop" class="form-control"
                            value="{{ request('bop') ?? 0 }}" min="0">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
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
                    <h5 class="mb-3">HPP untuk:
                        <span class="badge bg-primary">{{ $selectedProduct->nama_produk }}</span>
                        <small class="text-muted">({{ $jumlah }} unit)</small>
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
                                    <td rowspan="{{ count($hppData['bahan']) + 1 }}"
                                        class="align-middle fw-semibold">BBB (Bahan Baku)</td>
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
                                    <td>Biaya total untuk seluruh produksi</td>
                                    <td class="text-end">Rp {{ number_format($hppData['totalBBB'], 0, ',', '.') }}</td>
                                </tr>

                                {{-- BTK --}}
                                <tr class="fw-semibold">
                                    <td>BTK (Tenaga Kerja)</td>
                                    <td>Biaya total untuk seluruh produksi</td>
                                    <td class="text-end">Rp {{ number_format($hppData['totalBTK'], 0, ',', '.') }}</td>
                                </tr>

                                {{-- BOP --}}
                                <tr class="fw-semibold">
                                    <td>BOP (Overhead)</td>
                                    <td>Biaya total untuk seluruh produksi</td>
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

                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('admin.produksi.admin.produksi.hpp.pdf', [
                            'produk_id' => request('produk_id'),
                            'jumlah' => request('jumlah'),
                            'btk' => request('btk'),
                            'bop' => request('bop'),
                        ]) }}" class="btn btn-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
