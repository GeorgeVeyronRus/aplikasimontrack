@extends(backpack_view('blank'))

@section('content')

    @if($isOverBudget)
        <div class="alert alert-warning">
            <strong>Peringatan!</strong> Pengeluaran bulan ini sudah melebihi budget yang ditentukan.
        </div>
    @endif

        <div class="row mb-4">
        <div class="col-md-4 d-flex">
            <div class="card text-white bg-success w-100 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Pendapatan</h5>
                        <p class="card-text mb">Pendapatan Anda bulan {{$bulan}}</p>
                        <p class="card-text h4 mb-0">
                            Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="ml-3">
                        <i class="la la-money-bill la-3x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-flex">
            <div class="card text-white bg-danger w-100 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Pengeluaran</h5>
                        <p class="card-text mb">Pengeluaran Anda bulan {{$bulan}}</p>
                        <p class="card-text h4 mb-0">
                            Rp {{ number_format($pengeluaranBulanIni ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="ml-3">
                        <i class="la la-credit-card la-3x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-flex">
            @php
                $budget = $budgetBulanIni ?? 0;
                $pengeluaran = $pengeluaranBulanIni ?? 0;
                $progress = $budget > 0 ? min(100, round(($pengeluaran / $budget) * 100)) : 0;
                $barColor = $progress <= 50 ? 'bg-success' : ($progress < 100 ? 'bg-warning' : 'bg-danger');
                $sisa = $budget - $pengeluaran;
            @endphp

            <div class="card bg-primary text-white w-100 h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Budget Bulan Ini</h5>
                        <p class="card-text mb-1">Budget: Rp {{ number_format($budget, 0, ',', '.') }}</p>
                        <p class="card-text mb-2">Pengeluaran: Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>

                        <div class="progress">
                            <div class="progress-bar {{ $barColor }}" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $progress }}%
                            </div>
                        </div>
                    </div>
                    <small class="text-white mt-2 d-block">Sisa Budget: Rp {{ number_format($sisa < 0 ? 0 : $sisa, 0, ',', '.') }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection
