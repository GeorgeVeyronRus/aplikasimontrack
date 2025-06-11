<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendapatan;
use PDF;

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
            ->whereMonth('tanggal', $month)
            ->where('user_id', backpack_user()->id);


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

    public function exportPdf(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year  = $request->input('year',  date('Y'));
        $userId = backpack_user()->id;

        $pendapatans = Pendapatan::where('user_id', $userId)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->orderBy('tanggal', 'asc')
            ->get();

        $totalGaji = $pendapatans->sum('jumlah');

        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        ];

        $namaBulan = $months[$month];

        $pdf = PDF::loadView('vendor.backpack.custom.laporan_pendapatan_pdf', [
            'pendapatans' => $pendapatans,
            'totalGaji' => $totalGaji,
            'month' => $month,
            'year' => $year,
            'namaBulan' => $namaBulan,
        ]);

        return $pdf->download("Laporan_Pendapatan_{$namaBulan}_{$year}.pdf");
    }


}
