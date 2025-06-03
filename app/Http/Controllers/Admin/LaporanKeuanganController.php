<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Tangkap tahun dari request, default tahun sekarang
        $tahun = $request->input('tahun', date('Y'));

        // Ambil data pendapatan dan pengeluaran per bulan di tahun tersebut
        // Misal kamu punya model Pendapatan dan Pengeluaran yang punya kolom 'tanggal' dan 'jumlah'

        $data = collect();

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $pendapatan = Pendapatan::whereYear('tanggal', $tahun)
                        ->whereMonth('tanggal', $bulan)
                        ->sum('jumlah');
            $pengeluaran = Pengeluaran::whereYear('tanggal', $tahun)
                        ->whereMonth('tanggal', $bulan)
                        ->sum('jumlah');
            $selisih = $pendapatan - $pengeluaran;

            // Tambah data hanya jika pendapatan atau pengeluaran > 0
            if ($pendapatan > 0 || $pengeluaran > 0) {
                $data->push((object)[
                    'bulan' => $bulan,
                    'pendapatan' => $pendapatan,
                    'pengeluaran' => $pengeluaran,
                    'selisih' => $selisih,
                ]);
            }
        }


        // Hitung total
        $totalPendapatan = $data->sum('pendapatan');
        $totalPengeluaran = $data->sum('pengeluaran');
        $saldoAkhir = $totalPendapatan - $totalPengeluaran;

        return view('vendor.backpack.custom.laporan_keuangan', compact('tahun', 'data', 'totalPendapatan', 'totalPengeluaran', 'saldoAkhir'));
    }

    public function exportPdf(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        $data = collect();

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $pendapatan = Pendapatan::whereYear('tanggal', $tahun)
                        ->whereMonth('tanggal', $bulan)
                        ->sum('jumlah');
            $pengeluaran = Pengeluaran::whereYear('tanggal', $tahun)
                        ->whereMonth('tanggal', $bulan)
                        ->sum('jumlah');
            $selisih = $pendapatan - $pengeluaran;

            if ($pendapatan > 0 || $pengeluaran > 0) {
                $data->push((object)[
                    'bulan' => $bulan,
                    'pendapatan' => $pendapatan,
                    'pengeluaran' => $pengeluaran,
                    'selisih' => $selisih,
                ]);
            }
        }

        $totalPendapatan = $data->sum('pendapatan');
        $totalPengeluaran = $data->sum('pengeluaran');
        $saldoAkhir = $totalPendapatan - $totalPengeluaran;

        $pdf = Pdf::loadView('vendor.backpack.custom.laporan_keuangan_pdf', [
            'tahun' => $tahun,
            'data' => $data,
            'totalPendapatan' => $totalPendapatan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoAkhir' => $saldoAkhir,
        ])->setPaper('A4', 'landscape');

        return $pdf->download('laporan-keuangan-' . $tahun . '.pdf');
    }

}
