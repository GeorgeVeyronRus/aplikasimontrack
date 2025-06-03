<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengeluaran {{ $bulanNama }} {{ $year }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h3>Laporan Pengeluaran Bulan {{ $bulanNama }} Tahun {{ $year }}</h3>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluarans as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}</td>
                <td>{{ $item->kategori_pengeluaran->nama ?? '-' }}</td>
                <td>{{ $item->deskripsi ?? '-' }}</td>
                <td style="text-align: right;">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="total">Total Pengeluaran</td>
                <td class="total" style="text-align: right;">{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>