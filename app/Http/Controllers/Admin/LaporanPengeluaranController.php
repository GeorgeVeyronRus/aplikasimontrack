<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\KategoriPengeluaran;

class LaporanPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter bulan & tahun, default bulan dan tahun sekarang
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Query pengeluaran di bulan & tahun terpilih, relasi ke kategori pengeluaran
        $pengeluarans = Pengeluaran::with('kategori_pengeluaran')
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Total pengeluaran bulan itu
        $totalPengeluaran = $pengeluarans->sum('jumlah');

        // Untuk dropdown bulan dan tahun di view
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
        $years = range(date('Y') - 25, date('Y')); // contoh 5 tahun terakhir

        return view('vendor.backpack.custom.laporan_pengeluaran', compact('pengeluarans', 'totalPengeluaran', 'months', 'month', 'year', 'years'));
    }
}
