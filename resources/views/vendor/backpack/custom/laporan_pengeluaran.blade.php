@extends(backpack_view('blank'))

@section('header')
    <section class="container-fluid">
        <div class="d-flex justify-content-end">
            <ol class="breadcrumb bg-transparent px-0 pb-0 mb-0">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item active">Laporan Keuangan</li>
            </ol>
        </div>
    </section>
@endsection

@section('content')
    <div class="container mt-4">
    <h2>Laporan Pengeluaran</h2>
    
        <div class="d-flex justify-content-between align-items-end flex-wrap mb-4">
            <!-- Form Filter -->
            <form method="GET" class="d-flex flex-wrap align-items-end">
                <div class="form-group d-flex align-items-center mb-2" style="margin-right: 1.5rem;">
                    <label for="month" style="margin-right: 0.5rem; margin-bottom: 0;">Bulan</label>
                    <select name="month" id="month" class="form-control">
                        @foreach($months as $num => $name)
                            <option value="{{ $num }}" {{ $num == $month ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-flex align-items-center mb-2" style="margin-right: 1.5rem;">
                    <label for="kategori" style="margin-right: 0.5rem; margin-bottom: 0;">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $k)
                            <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-flex align-items-center mb-2" style="margin-right: 1.5rem;">
                    <label for="year" style="margin-right: 0.5rem; margin-bottom: 0;">Tahun</label>
                    <select name="year" id="year" class="form-control">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>

            <!-- Form Export PDF -->
            <form action="{{ route('laporan-pengeluaran.pdf') }}" method="GET" class="mb-2">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="kategori" value="{{ $kategori }}">
                <button type="submit" class="btn btn-danger">
                    <i class="la la-file-pdf-o"></i> Export PDF
                </button>
            </form>
        </div>

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
