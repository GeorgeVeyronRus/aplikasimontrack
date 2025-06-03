@extends(backpack_view('blank'))

@section('content')
<div class="container">
    <h3>Laporan Keuangan Tahunan</h3>

    <div class="d-flex align-items-center justify-content-between mb-4" style="gap: 1rem;">
        <!-- Form Filter -->
        <form method="GET" action="{{ route('laporan.keuangan') }}" class="d-flex align-items-center mb-0 flex-grow-1">
            <label for="tahun" class="me-2 mb-0" style="white-space: nowrap;">Filter Tahun:</label>
            <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-control w-auto me-3">
                @for ($y = date('Y'); $y >= 2000; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <noscript>
                <button type="submit" class="btn btn-primary">Filter</button>
            </noscript>
        </form>

        <!-- Form Export PDF -->
        <form action="{{ route('laporan-keuangan.pdf') }}" method="GET" class="d-flex align-items-center mb-0">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <button type="submit" class="btn btn-danger">
                <i class="la la-file-pdf-o"></i> Export PDF
            </button>
        </form>
    </div>


    
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
