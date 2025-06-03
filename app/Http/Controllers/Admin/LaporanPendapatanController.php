<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendapatan;

class LaporanPendapatanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter bulan & tahun, default ke bulan & tahun sekarang
        $month = $request->input('month', date('m'));
        $year  = $request->input('year',  date('Y'));

        // Query data pendapatan sesuai filter
        $query = Pendapatan::query()
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month);

        $pendapatans = $query->orderBy('tanggal', 'asc')->get();

        // Total gaji di periode terpilih
        $totalGaji = $pendapatans->sum('jumlah');

        // Untuk dropdown bulan & tahun
        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
        // contoh rentang 25 tahun ke belakang hingga sekarang
        $years = range(date('Y') - 25, date('Y'));

        return view('vendor.backpack.custom.laporan_pendapatan', compact(
            'pendapatans',
            'totalGaji',
            'months',
            'month',
            'year',
            'years'
        ));
    }
}
