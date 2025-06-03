@extends(backpack_view('blank'))

@section('content')
<div class="container">
    <h3>Laporan Keuangan Tahunan</h3>

    <form method="GET" action="{{ route('laporan.keuangan') }}" class="mb-4">
        <label for="tahun">Filter Tahun:</label>
        <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-control w-auto d-inline-block">
            @for ($y = date('Y'); $y >= 2000; $y--)
                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <noscript><button type="submit" class="btn btn-primary">Filter</button></noscript>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Pendapatan (Rp)</th>
                <th>Pengeluaran (Rp)</th>
                <th>Selisih (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::create()->month($item->bulan)->format('F') }}</td>
                    <td class="text-right">{{ number_format($item->pendapatan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->pengeluaran, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->selisih, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-center">Total</th>
                <th class="text-right">{{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                <th class="text-right">{{ number_format($totalPengeluaran, 0, ',', '.') }}</th>
                <th class="text-right">{{ number_format($saldoAkhir, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
