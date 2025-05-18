<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>HPP PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #aaa; padding: 8px; vertical-align: top; }
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
            <!-- BBB (Bahan Baku) -->
            <tr>
                <td rowspan="{{ count($bahan) + 1 }}">BBB (Bahan Baku)</td>
                <td>
                    {{ $bahan[0]['nama'] }} ({{ $bahan[0]['jumlah'] }} {{ $bahan[0]['satuan'] }}) x Rp {{ number_format($bahan[0]['harga'], 0, ',', '.') }}
                </td>
                <td class="text-end">
                    Rp {{ number_format($bahan[0]['subtotal'], 0, ',', '.') }}
                </td>
            </tr>
            @foreach ($bahan as $index => $item)
                @if ($index > 0)
                <tr>
                    <td>
                        {{ $item['nama'] }} ({{ $item['jumlah'] }} {{ $item['satuan'] }}) x Rp {{ number_format($item['harga'], 0, ',', '.') }}
                    </td>
                    <td class="text-end">
                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </td>
                </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="1" class="fw-bold">Total BBB</td>
                <td class="fw-bold text-end">Rp {{ number_format($totalBBB, 0, ',', '.') }}</td>
            </tr>

            <!-- BTK -->
            <tr>
                <td colspan="2">BTK (Tenaga Kerja)</td>
                <td class="text-end">Rp {{ number_format($btk, 0, ',', '.') }}</td>
            </tr>

            <!-- BOP -->
            <tr>
                <td colspan="2">BOP (Overhead)</td>
                <td class="text-end">Rp {{ number_format($bop, 0, ',', '.') }}</td>
            </tr>

            <!-- Total HPP -->
            <tr>
                <td colspan="2" class="fw-bold">Total HPP</td>
                <td class="fw-bold text-end">Rp {{ number_format($totalHPP, 0, ',', '.') }}</td>
            </tr>

            <!-- HPP per Unit -->
            <tr>
                <td colspan="2" class="fw-bold">HPP per Unit</td>
                <td class="fw-bold text-end">Rp {{ number_format($hppPerUnit, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p class="mt-3">Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d-m-Y H:i') }}</p>

</body>
</html>
