<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendapatan;
use Carbon\Carbon;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $pendapatanBulanIni = Pendapatan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        return view(backpack_view('dashboard'), compact('pendapatanBulanIni'));
    }
}