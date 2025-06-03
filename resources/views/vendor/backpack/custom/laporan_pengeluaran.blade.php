@extends(backpack_view('blank'))

@section('content')
    <div class="container mt-4">
    <h2>Laporan Pengeluaran</h2>

    <form method="GET" class="form-inline mb-4">
        <label for="month" class="mr-2">Bulan</label>
        <select name="month" id="month" class="form-control mr-3">
            @foreach($months as $num => $name)
                <option value="{{ $num }}" {{ $num == $month ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>

        <label for="kategori" class="mr-2">Kategori</label>
        <select name="kategori" id="kategori" class="form-control mr-3">
            <option value="">Semua Kategori</option>
            @foreach($kategoriList as $k)
                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>

        <label for="year" class="mr-2">Tahun</label>
        <select name="year" id="year" class="form-control mr-3">
            @foreach($years as $y)
                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori Pengeluaran</th>
                <th>Deskripsi</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengeluarans as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->kategori_pengeluaran->nama ?? '-' }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td class="text-right">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data pengeluaran</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total Pengeluaran</th>
                <th class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
