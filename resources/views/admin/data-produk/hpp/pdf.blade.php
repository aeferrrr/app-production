<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>HPP PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #aaa; padding: 8px; }
        th { background-color: #f2f2f2; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .mt-3 { margin-top: 1rem; }
    </style>
</head>
<body>
    <h2>Perhitungan HPP</h2>
    <p><strong>Produk:</strong> {{ $produk->nama_produk }}</p>
    <p><strong>Jumlah Produksi:</strong> {{ $jumlah }} unit</p>

    <table>
        <thead>
            <tr>
                <th>Jenis</th>
                <th>Rincian</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- BBB -->
            <tr>
                <td rowspan="{{ count($bahan) + 1 }}">BBB (Bahan Baku)</td>
            </tr>
            @foreach ($bahan as $item)
                <tr>
                    <td>{{ $item['nama'] }} ({{ $item['jumlah'] }} {{ $item['satuan'] }}) x Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="fw-bold text-end">Total BBB</td>
                <td class="fw-bold text-end">Rp {{ number_format($totalBBB, 0, ',', '.') }}</td>
            </tr>

            <!-- BTK -->
            <tr>
                <td>BTK (Tenaga Kerja)</td>
                <td class="text-end">Rp {{ number_format($btk, 0, ',', '.') }}</td>
            </tr>

            <!-- BOP -->
            <tr>
                <td>BOP (Overhead)</td>
                <td class="text-end">Rp {{ number_format($bop, 0, ',', '.') }}</td>
            </tr>

            <!-- HPP Total -->
            <tr>
                <td class="fw-bold">Total HPP</td>
                <td class="fw-bold text-end">Rp {{ number_format($totalHPP, 0, ',', '.') }}</td>
            </tr>

            <!-- HPP Per Unit -->
            <tr>
                <td class="fw-bold">HPP per Unit</td>
                <td class="fw-bold text-end">Rp {{ number_format($hppPerUnit, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p class="mt-3">Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
</body>
</html>
