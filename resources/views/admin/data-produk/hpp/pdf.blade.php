<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan HPP - {{ $pesanan->kode_pesanan }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }

        h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 5px;
        }

        h4 {
            text-align: center;
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 20px;
        }

        p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #e0e0e0;
        }

        .text-right {
            text-align: right;
        }

        .summary-table td {
            border: none;
        }

        .mb-2 {
            margin-bottom: 12px;
        }

        .mt-4 {
            margin-top: 20px;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
            font-style: italic;
        }

        .section-title {
            background-color: #f0f0f0;
            padding: 6px;
            font-weight: bold;
            text-align: left;
        }
    </style>
</head>

<body>

    <h2>LAPORAN HARGA POKOK PRODUKSI</h2>
    <h4>Kode Pesanan: {{ $pesanan->kode_pesanan }}</h4>

    <p class="mb-2"><strong>Tanggal Pesanan:</strong>
        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d-m-Y') }}</p>

    <p><strong>Total Produk Dipesan:</strong> {{ $totalJumlah }} pcs</p>

    <div class="section-title">Rincian Biaya Bahan Baku (BBB)</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bahan</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga per Unit</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bahan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>{{ $item['satuan'] }}</td>
                    <td class="text-right">Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Ringkasan Perhitungan HPP</div>
    <table class="summary-table">
        <tr>
            <td>Total Biaya Bahan Baku (BBB)</td>
            <td class="text-right">Rp{{ number_format($totalBBB, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Biaya Tenaga Kerja (BTK)</td>
            <td class="text-right">Rp{{ number_format($totalBTK, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Biaya Overhead Pabrik (BOP)</td>
            <td class="text-right">Rp{{ number_format($totalBOP, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total HPP</strong></td>
            <td class="text-right"><strong>Rp{{ number_format($totalHPP, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td><strong>HPP per Unit</strong></td>
            <td class="text-right"><strong>Rp{{ number_format($hppPerUnit, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    @isset($fakturData)
        <div class="section-title mt-4">Faktur Penjualan & Laba Kotor</div>
        <table class="summary-table">
            <tr>
                <td>Total Pendapatan</td>
                <td class="text-right">Rp{{ number_format($fakturData['totalPendapatan'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Laba Kotor</td>
                <td class="text-right">Rp{{ number_format($fakturData['labaKotor'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Margin (%)</td>
                <td class="text-right">{{ number_format($fakturData['marginPersen'], 2, ',', '.') }}%</td>
            </tr>
        </table>
    @endisset

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
    </div>

</body>

</html>
