@extends(backpack_view('blank'))

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="incomereportchart mb-0">Laporan Pendapatan
                    
                </h4>

                <a href="{{ url('/admin/laporan-pendapatan') }}" class="btn btn-primary">
                Lihat laporan
                </a>
            </div>

            <form method="GET" class="mb-3">
                <select id="rangeSelector" class="form-control w-auto d-inline-block mb-2">
                <option value="1w">1 Week</option>
                <option value="1m">1 Month</option>
                <option value="3m">3 Months</option>
                <option value="12m" selected>12 Months</option>
                </select>
            </form>

            <canvas id="combinedChart" height="200"></canvas>
        </div>

@endsection

@push('after_scripts')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
<script>
    let combinedChart;

    function loadCombinedChart(range = '12m') {
        const pendapatanPromise = fetch(`/admin/dashboard/income-report-data-pendapatan?range=${range}`).then(res => res.json());
        const pengeluaranPromise = fetch(`/admin/dashboard/income-report-data-pengeluaran?range=${range}`).then(res => res.json());

        Promise.all([pendapatanPromise, pengeluaranPromise]).then(([pendapatanData, pengeluaranData]) => {
            const labels = pendapatanData.map(item => item.label);

            const pendapatanValues = pendapatanData.map(item => item.pendapatan);
            const pengeluaranValues = pengeluaranData.map(item => item.pengeluaran);

            if (combinedChart) combinedChart.destroy();

            const ctx = document.getElementById('combinedChart').getContext('2d');
            combinedChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Pendapatan',
                            data: pendapatanValues,
                            borderColor: '#42ba96',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: false,
                            tension: 0.3
                        },
                        {
                            label: 'Pengeluaran',
                            data: pengeluaranValues,
                            borderColor: 'rgb(255, 99, 132)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: false,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    }
                }
            });
        });
    }

    document.getElementById('rangeSelector').addEventListener('change', function () {
        loadCombinedChart(this.value);
    });

    loadCombinedChart();
</script>
@endpush




