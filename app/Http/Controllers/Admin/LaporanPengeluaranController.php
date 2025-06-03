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
        // Ambil filter bulan, tahun, dan kategori
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $kategori = $request->input('kategori'); // ← Tambah ini

        $kategoriList = KategoriPengeluaran::orderBy('nama')->get();

        // Query data pengeluaran
        $query = Pengeluaran::with('kategori_pengeluaran')
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
}
