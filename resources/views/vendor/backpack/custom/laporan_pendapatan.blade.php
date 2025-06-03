@extends(backpack_view('blank'))

@section('content')
    <div class="container mt-4">
        <h2>Laporan Pendapatan</h2>

        <div class="d-flex justify-content-between align-items-end mb-4" style="gap: 1rem;">
            <!-- Form Filter -->
            <form method="GET" class="form-inline">
                <div class="form-group mr-2">
                    <label for="month" class="mr-2">Bulan</label>
                    <select name="month" id="month" class="form-control">
                        @foreach($months as $num => $name)
                            <option value="{{ $num }}" {{ $num == $month ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mr-2">
                    <label for="year" class="mr-2">Tahun</label>
                    <select name="year" id="year" class="form-control">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

            <!-- Form Export PDF -->
            <form action="{{ route('laporan-pendapatan.pdf') }}" method="GET">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">
                <button type="submit" class="btn btn-danger">
                    <i class="la la-file-pdf-o"></i> Export PDF
                </button>
            </form>
        </div>
       

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th class="text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pendapatans as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->tipe_pendapatan }}</td>
                        <td class="text-right">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data pendapatan</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-right">Total Gaji</th>
                    <th class="text-right">Rp {{ number_format($totalGaji, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

    </div>
    
@endsection
