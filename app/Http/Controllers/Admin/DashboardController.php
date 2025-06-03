<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BudgetPengeluarans;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $pendapatanBulanIni = Pendapatan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');
        
        $pengeluaranBulanIni = Pengeluaran::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $budgetBulanIni = BudgetPengeluarans::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->value('jumlah');

        $isOverBudget = false;

        if ($budgetBulanIni !== null && $pengeluaranBulanIni > $budgetBulanIni) {
            $isOverBudget = true;
        }

        return view(backpack_view('dashboard'), compact('pendapatanBulanIni','pengeluaranBulanIni','budgetBulanIni','isOverBudget'));
    }
}