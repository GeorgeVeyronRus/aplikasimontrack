<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LaporanKeuanganController;
use App\Http\Controllers\Admin\LaporanPengeluaranController;
use App\Http\Controllers\Admin\LaporanPendapatanController;

Route::get('/', function () {
    return redirect('/admin');
});

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routesAdd commentMore actions
    Route::crud('pendapatan', 'PendapatanCrudController');
    Route::crud('pengeluaran', 'PengeluaranCrudController');
    Route::crud('kategori-pengeluaran', 'KategoriPengeluaranCrudController');
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('backpack.dashboard');
    Route::get('laporan-pengeluaran', [App\Http\Controllers\Admin\LaporanPengeluaranController::class, 'index'])->name('laporan.pengeluaran');
    Route::get('laporan-pengeluaran', [LaporanPengeluaranController::class, 'index'])->name('laporan.keuangan');
    Route::get('laporan-pendapatan', [LaporanPendapatanController::class, 'index'])->name('laporan.pendapatan');
    Route::get('laporan-pendapatan', [App\Http\Controllers\Admin\LaporanPendapatanController::class, 'index'])->name('laporan.pendapatan');
}); // this should be the absolute last line of this file

