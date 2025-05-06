<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produksi Selesai</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Produksi Selesai</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Pesanan</th>
                <th>Tanggal Produksi</th>
                <th>Produk</th>
                <th>Karyawan</th>
                <th>Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->pesanan->kode_pesanan ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                <td>
                    @foreach($item->pesanan->detailPesanan as $detail)
                        {{ $detail->produk->nama_produk }} (Qty: {{ $detail->jumlah }})<br>
                    @endforeach
                </td>
                <td>
                    @foreach($item->users as $user)
                        {{ $user->name }} - Rp{{ number_format($user->pivot->upah) }}<br>
                    @endforeach
                </td>
                <td>Rp{{ number_format($item->users->sum('pivot.upah')) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
