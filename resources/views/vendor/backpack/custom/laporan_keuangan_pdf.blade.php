<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Laporan Keuangan {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f0f0f0; }
        tfoot td { font-weight: bold; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Laporan Keuangan Tahun {{ $tahun }}</h3>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Pendapatan (Rp)</th>
                <th>Pengeluaran (Rp)</th>
                <th>Selisih (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::create()->month($item->bulan)->format('F') }}</td>
                    <td>{{ number_format($item->pendapatan, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->pengeluaran, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->selisih, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td>{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                <td>{{ number_format($saldoAkhir, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
