<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use App\Models\BudgetPengeluarans;
use Backpack\CRUD\app\Library\Widget;



class DashboardController extends Controller
{
    public function dashboard()
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $pendapatanBulanIni = Pendapatan::where('user_id', backpack_user()->id) // <--- tambah ini
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');
        
        $pengeluaranBulanIni = Pengeluaran::where('user_id', backpack_user()->id) // <--- tambah ini
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $budgetBulanIni = BudgetPengeluarans::where('user_id', backpack_user()->id) // <--- tambah ini
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->value('jumlah');

        $isOverBudget = false;

        if ($budgetBulanIni !== null && $pengeluaranBulanIni > $budgetBulanIni) {
            $isOverBudget = true;
        }

        return view(backpack_view('dashboard'), compact('bulan','tahun','pendapatanBulanIni','pengeluaranBulanIni','budgetBulanIni','isOverBudget'));
    }


    public function incomeChartDataPendapatan(Request $request)
    {
        $range = $request->get('range', '12m');
        $now = Carbon::now();
        $data = [];

        switch ($range) {
            case '1w':
                for ($i = 6; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i)->format('Y-m-d');
                    $pendapatan = DB::table('pendapatan')
                        ->where('user_id', backpack_user()->id) // filter user
                        ->whereDate('tanggal', $date)
                        ->sum('jumlah');
                    $data[] = ['label' => Carbon::parse($date)->format('D'), 'pendapatan' => $pendapatan];
                }
                break;

            case '1m':
                for ($i = 29; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i)->format('Y-m-d');
                    $pendapatan = DB::table('pendapatan')
                        ->where('user_id', backpack_user()->id) // filter user
                        ->whereDate('tanggal', $date)
                        ->sum('jumlah');
                    $data[] = ['label' => Carbon::parse($date)->format('d M'), 'pendapatan' => $pendapatan];
                }
                break;

            case '3m':
                for ($i = 2; $i >= 0; $i--) {
                    $date = $now->copy()->subMonths($i);
                    $pendapatan = DB::table('pendapatan')
                        ->where('user_id', backpack_user()->id) // filter user
                        ->whereYear('tanggal', $date->year)
                        ->whereMonth('tanggal', $date->month)
                        ->sum('jumlah');
                    $data[] = ['label' => $date->format('M Y'), 'pendapatan' => $pendapatan];
                }
                break;

            default: // 12m
                for ($i = 11; $i >= 0; $i--) {
                    $date = $now->copy()->subMonths($i);
                    $pendapatan = DB::table('pendapatan')
                        ->where('user_id', backpack_user()->id) // filter user
                        ->whereYear('tanggal', $date->year)
                        ->whereMonth('tanggal', $date->month)
                        ->sum('jumlah');
                    $data[] = ['label' => $date->format('M Y'), 'pendapatan' => $pendapatan];
                }
        }

        return response()->json($data);
    }

    public function incomeChartDataPengeluaran(Request $request)
    {
        $range = $request->get('range', '12m');
        $now = Carbon::now();
        $data = [];

        switch ($range) {
            case '1w':
                for ($i = 6; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i)->format('Y-m-d');
                    $pengeluaran = DB::table('pengeluaran')
                        ->where('user_id', backpack_user()->id) // filter user
                        ->whereDate('tanggal', $date)
                        ->sum('jumlah');
                    $data[] = ['label' => Carbon::parse($date)->format('D'), 'pengeluaran' => $pengeluaran];
                }
                break;

            case '1m':
                for ($i = 29; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i)->format('Y-m-d');
                    $pengeluaran = DB::table('pengeluaran')
                        ->where('user_id', backpack_user()->id) // filter user
                        ->whereDate('tanggal', $date)
                        ->sum('jumlah');
                    $data[] = ['label' => Carbon::parse($date)->format('d M'), 'pengeluaran' => $pengeluaran];
                }
                break;

            case '3m':
                for ($i = 2; $i >= 0; $i--) {
                    $date = $now->copy()->subMonths($i);
                    $pengeluaran = DB::table('pengeluaran')
                        ->where('user_id', backpack_user()->id) // filter user
                        ->whereYear('tanggal', $date->year)
                        ->whereMonth('tanggal', $date->month)
                        ->sum('jumlah');
                    $data[] = ['label' => $date->format('M Y'), 'pengeluaran' => $pengeluaran];
                }
                break;

            default: // 12m
                for ($i = 11; $i >= 0; $i--) {
                    $date = $now->copy()->subMonths($i);
                    $pengeluaran = DB::table('pengeluaran')
                        ->where('user_id', backpack_user()->id) // filter user
                        ->whereYear('tanggal', $date->year)
                        ->whereMonth('tanggal', $date->month)
                        ->sum('jumlah');
                    $data[] = ['label' => $date->format('M Y'), 'pengeluaran' => $pengeluaran];
                }
        }

        return response()->json($data);
    }

}