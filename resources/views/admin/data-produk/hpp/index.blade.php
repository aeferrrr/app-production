@extends('layout.layout')
@section('title', 'Perhitungan HPP')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Perhitungan Harga Pokok Produksi (HPP)</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Input Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.produksi.hpp') }}" method="GET" class="row align-items-end">
                <div class="col-md-3 mb-3">
                    <label for="produk_id">Nama Produk</label>
                    <select name="produk_id" id="produk_id" class="form-control">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produk as $item)
                            <option value="{{ $item->id_produk }}" {{ (request('produk_id') == $item->id_produk) ? 'selected' : '' }}>
                                {{ $item->kode_produk }} - {{ $item->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" value="{{ request('jumlah') ?? '' }}" min="1" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="btk">BTK per Unit</label>
                    <input type="number" name="btk" class="form-control" value="{{ request('btk') ?? 0 }}" min="0">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="bop">BOP per Unit</label>
                    <input type="number" name="bop" class="form-control" value="{{ request('bop') ?? 0 }}" min="0">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="profit">Keuntungan (%)</label>
                    <input type="number" name="profit" class="form-control" value="{{ request('profit') ?? 0 }}" min="0">
                </div>
                <div class="col-md-1 mb-3">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-calculator fa-sm"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($hppData)
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>HPP untuk: <strong>{{ $selectedProduct->nama_produk }}</strong> ({{ $jumlah }} unit)</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>Jenis</th>
                            <th>Rincian</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BBB -->
                        <tr>
                            <td rowspan="{{ count($hppData['bahan']) + 1 }}">BBB (Bahan Baku)</td>
                        </tr>
                        @foreach($hppData['bahan'] as $bahan)
                        <tr>
                            <td>{{ $bahan['nama'] }} ({{ $bahan['jumlah'] }} {{ $bahan['satuan'] }}) x Rp {{ number_format($bahan['harga'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($bahan['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="font-weight-bold bg-light">
                            <td>Total BBB</td>
                            <td>Rp {{ number_format($hppData['totalBBB'], 0, ',', '.') }}</td>
                        </tr>

                        <!-- BTK -->
                        <tr class="font-weight-bold">
                            <td>BTK (Tenaga Kerja)</td>
                            <td>Rp {{ number_format(request('btk'), 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($hppData['totalBTK'], 0, ',', '.') }}</td>
                        </tr>

                        <!-- BOP -->
                        <tr class="font-weight-bold">
                            <td>BOP (Overhead)</td>
                            <td>Rp {{ number_format(request('bop'), 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($hppData['totalBOP'], 0, ',', '.') }}</td>
                        </tr>

                        <!-- HPP -->
                        <tr class="bg-primary text-white font-weight-bold">
                            <td>HPP Total</td>
                            <td colspan="2">Rp {{ number_format($hppData['totalHPP'], 0, ',', '.') }} (Rp {{ number_format($hppData['hppPerUnit'], 0, ',', '.') }} / unit)</td>
                        </tr>

                        <!-- Harga Jual -->
                        @php
                            $profitPercent = request('profit') ?? 0;
                            $profitAmount = $hppData['hppPerUnit'] * ($profitPercent / 100);
                            $hargaJual = $hppData['hppPerUnit'] + $profitAmount;
                        @endphp
                        <tr class="bg-success text-white font-weight-bold">
                            <td>Harga Jual</td>
                            <td>+ {{ $profitPercent }}% Keuntungan</td>
                            <td>Rp {{ number_format($hargaJual * $jumlah, 0, ',', '.') }} (Rp {{ number_format($hargaJual, 0, ',', '.') }} / unit)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
