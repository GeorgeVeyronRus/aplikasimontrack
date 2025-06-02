@extends(backpack_view('blank'))

@section('content')
    <h2>Laporan Keuangan</h2>
    <div class="card p-4">
        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        <p><strong>Saldo:</strong> Rp {{ number_format($saldo, 0, ',', '.') }}</p>

        <hr>

        <h5>Pengeluaran Bulanan</h5>
        <ul>
            @foreach ($monthly as $data)
                <li>Bulan {{ $data->bulan }}: Rp {{ number_format($data->total, 0, ',', '.') }}</li>
            @endforeach
        </ul>
    </div>
@endsection
