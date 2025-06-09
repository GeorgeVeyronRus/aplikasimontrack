@extends(backpack_view('blank'))

@section('header')
    <section class="container-fluid">
        <div class="d-flex justify-content-end">
            <ol class="breadcrumb bg-transparent px-0 pb-20 mb-0">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </section>
@endsection

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
                        <p class="card-text mb">Pendapatan Anda bulan di {{$bulan}}</p>
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
                        <p class="card-text mb">Pengeluaran Anda bulan di {{$bulan}}</p>
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
                <h4 class="incomereportchart mb-0 flex-grow-1">
                    Laporan Pendapatan & Pengeluaran
                </h4>

                <div class="d-flex" style="gap: 0.5rem;">
                    <a href="{{ url('/admin/laporan-pendapatan') }}" class="btn btn-success">
                        Lihat laporan Pendapatan
                    </a>
                    <a href="{{ url('/admin/laporan-pengeluaran') }}" class="btn btn-danger">
                        Lihat laporan Pengeluaran
                    </a>
                </div>
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

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <b>Pengeluaran Berdasarkan Kategori (Bulan Ini)</b>
                        </div>
                        <div class="card-body d-flex flex-row flex-wrap" style="min-height:400px;">
                            <div style="flex: 1 1 0; min-width: 0; display: flex; align-items: center; justify-content: center;">
                                <canvas id="pieExpenseByCategoryThisMonth" style="width: 100%; max-width: 500px; height: 400px;"></canvas>
                            </div>
                            <div class="ps-4" style="flex: 1 1 0; min-width: 0;">
                                <h5 class="mb-3">Rincian Kategori</h5>
                                <div id="categoryDetailsList"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

    let pieExpenseByCategoryThisMonthChart;

    function loadPieExpenseByCategoryThisMonth() {
        fetch('/admin/dashboard/expense-by-category-this-month')
            .then(res => res.json())
            .then(data => {
                const ctxPie = document.getElementById('pieExpenseByCategoryThisMonth').getContext('2d');
                const detailsList = document.getElementById('categoryDetailsList');

                if (pieExpenseByCategoryThisMonthChart) pieExpenseByCategoryThisMonthChart.destroy();
                detailsList.innerHTML = '';

                if (!data.length) {
                    ctxPie.clearRect(0, 0, 400, 400);
                    ctxPie.font = "16px Arial";
                    ctxPie.fillText("Tidak ada data pengeluaran", 50, 100);
                    return;
                }

                const labels = data.map(item => item.kategori);
                const values = data.map(item => item.total);
                const totalSemua = values.reduce((acc, val) => acc + val, 0);
                const backgroundColors = labels.map(() => '#' + Math.floor(Math.random()*16777215).toString(16));

                // Generate daftar kategori dan persentase
                data.forEach((item, index) => {
                    const percent = ((item.total / totalSemua) * 100).toFixed(1);
                    const color = backgroundColors[index];
                    const div = document.createElement('div');
                    div.classList.add('mb-2');
                    div.innerHTML = `
                        <span class="badge me-2" style="background-color: ${color};">&nbsp;&nbsp;</span>
                        <strong>${item.kategori}</strong>: Rp ${new Intl.NumberFormat('id-ID').format(item.total)} 
                        (<span class="text-muted">${percent}%</span>)
                    `;
                    detailsList.appendChild(div);
                });

                pieExpenseByCategoryThisMonthChart = new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: backgroundColors,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // penting agar tinggi mengikuti container
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.parsed || 0;
                                        return label + ': Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadPieExpenseByCategoryThisMonth();
    });
        
</script>
@endpush




