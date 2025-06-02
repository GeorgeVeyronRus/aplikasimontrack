<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LaporanKeuanganController;

Route::get('laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.keuangan');

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
    Route::get('laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.keuangan');
}); // this should be the absolute last line of this file



