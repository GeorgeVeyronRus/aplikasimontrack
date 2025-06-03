{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('pendapatan') }}"><i class="nav-icon la la-money-bill"></i> Pendapatan</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('kategori-pengeluaran') }}"><i class="nav-icon la-tags"></i> Kategori Pengeluaran</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('pengeluaran') }}"><i class="nav-icon la la-question"></i> Pengeluaran</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('laporan-pendapatan') }}"><i class="nav-icon la la-question"></i> Laporan Pendapatan</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('laporan-pengeluaran') }}"><i class="nav-icon la la-file-invoice-dollar"></i> Laporan Pengeluaran</a></li>