@extends(backpack_view('blank'))

@section('content')
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Pendapatan (Bulan Ini)</h5>
                    <p class="card-text h4">
                        Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Pengeluaran (Bulan Ini)</h5>
                    <p class="card-text h4">
                        Rp {{ number_format($pengeluaranBulanIni ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
