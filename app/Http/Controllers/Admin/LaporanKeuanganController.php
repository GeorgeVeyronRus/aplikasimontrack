<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanKeuanganController extends Controller
{
    public function index()
    {
        $totalPendapatan = Pendapatan::sum('jumlah');
        $totalPengeluaran = Pengeluaran::sum('jumlah');
        $saldo = $totalPendapatan - $totalPengeluaran;

        $monthly = Pengeluaran::selectRaw('MONTH(tanggal) as bulan, SUM(jumlah) as total')
                    ->groupBy('bulan')
                    ->get();

        return view('vendor.backpack.custom.laporan_keuangan', compact(
            'totalPendapatan',
            'totalPengeluaran',
            'saldo',
            'monthly'
        ));
    }
}
