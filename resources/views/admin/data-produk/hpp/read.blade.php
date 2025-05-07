@extends('layout.layout')
@section('title', 'Penjadwalan Produksi')
@section('content')
<form method="GET" action="{{ route('hpp.proses') }}" class="d-flex mb-4">
    <select name="id_produk" class="form-select me-2">
        @foreach($produkList as $produk)
            <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
        @endforeach
    </select>
    <input type="number" name="jumlah" class="form-control me-2" placeholder="Jumlah">
    <button type="submit" class="btn btn-primary">🔍 Proses</button>
</form>

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th class="bg-success text-white">BBB</th>
            <th class="bg-warning text-white">BTK</th>
            <th class="bg-danger text-white">BOP</th>
            <th class="bg-info text-white">Total HPP</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataHPP as $i => $row)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $row['kode_produk'] }}</td>
            <td>{{ $row['nama_produk'] }}</td>
            <td>{{ $row['jumlah'] }}</td>
            <td>Rp. {{ number_format($row['bbb'], 0, ',', '.') }}</td>
            <td>Rp. {{ number_format($row['btk'], 0, ',', '.') }}</td>
            <td>Rp. {{ number_format($row['bop'], 0, ',', '.') }}</td>
            <td>
                @if($row['total_hpp'] !== null)
                    Rp. {{ number_format($row['total_hpp'], 0, ',', '.') }}
                @else
                    <span class="text-muted">HPP belum siap</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
w
@endsection