{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('pendapatan') }}"><i class="nav-icon la la-money-bill"></i> Pendapatan</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('budget-pengeluarans') }}"><i class="nav-icon la la-balance-scale"></i> Budget Pengeluaran</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('kategori-pengeluaran') }}"><i class="nav-icon la la-list-alt"></i> Kategori Pengeluaran</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('pengeluaran') }}"><i class="nav-icon la la-credit-card"></i> Pengeluaran</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('laporan-pendapatan') }}"><i class="nav-icon la la-chart-line"></i> Laporan Pendapatan</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('laporan-pengeluaran') }}"><i class="nav-icon la la-chart-pie"></i> Laporan Pengeluaran</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('laporan-keuangan') }}"><i class="nav-icon la la-file-invoice-dollar"></i> Laporan Keuangan</a></li>
<li class="nav-item"><a class="nav-link" href="{{ url('admin/artikel-keuangan') }}"><i class="la la-book-open nav-icon"></i><span>Ilmu Keuangan</span></a></li>

