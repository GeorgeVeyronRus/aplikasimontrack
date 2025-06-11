<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\KategoriPengeluaran;
use PDF;

class LaporanPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter bulan, tahun, dan kategori
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $kategori = $request->input('kategori'); // ← Tambah ini

        $kategoriList = KategoriPengeluaran::orderBy('nama')->get();

        // Query data pengeluaran
        $query = Pengeluaran::with('kategori_pengeluaran')
            ->where('user_id', backpack_user()->id) // ← tambahkan ini
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month);
            

        if (!empty($kategori)) {
            $query->where('kategori_pengeluaran_id', $kategori);
        }

        $pengeluarans = $query->orderBy('tanggal', 'asc')->get();
        $totalPengeluaran = $pengeluarans->sum('jumlah');

        // Bulan dan Tahun untuk dropdown
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
        $years = range(date('Y') - 25, date('Y'));

        return view('vendor.backpack.custom.laporan_pengeluaran', compact(
            'pengeluarans',
            'totalPengeluaran',
            'months',
            'month',
            'year',
            'years',
            'kategoriList',
            'kategori' // ← kirim ke view
        ));
    }

        public function exportPdf(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $kategori = $request->input('kategori');

       $query = Pengeluaran::with('kategori_pengeluaran')
             ->where('user_id', backpack_user()->id)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month);

        if (!empty($kategori)) {
            $query->where('kategori_pengeluaran_id', $kategori);
        }

        $pengeluarans = $query->orderBy('tanggal', 'asc')->get();
        $totalPengeluaran = $pengeluarans->sum('jumlah');

        $bulanNama = $this->getMonthName($month);

        $pdf = PDF::loadView('vendor.backpack.custom.laporan_pengeluaran_pdf', compact(
            'pengeluarans', 'totalPengeluaran', 'month', 'year', 'bulanNama'
        ));

        return $pdf->download("laporan-pengeluaran-{$year}-{$month}.pdf");
    }

    private function getMonthName($month)
    {
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
        return $months[$month] ?? $month;
    }
}
