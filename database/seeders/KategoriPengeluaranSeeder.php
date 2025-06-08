<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPengeluaran;

class KategoriPengeluaranSeeder extends Seeder
{
    public function run()
    {
        $kategori = [
            [
                'nama' => 'Makanan',
                'deskripsi' => 'Biaya Makanan per hari',
            ],
            [
                'nama' => 'Pendidikan',
                'deskripsi' => 'Biaya Pendidikan',
            ],
            [
                'nama' => 'Kesehatan',
                'deskripsi' => 'Biaya Kesehatan',
            ],
            [
                'nama' => 'Transportasi',
                'deskripsi' => 'Biaya Transportasi harian',
            ],
            [
                'nama' => 'Hobi',
                'deskripsi' => 'Biaya Hobi',
            ],
            [
                'nama' => 'Hiburan',
                'deskripsi' => 'Biaya hiburan',
            ],
            [
                'nama' => 'Personal',
                'deskripsi' => 'Biaya Pribadi',
            ],
            [
                'nama' => 'Furniture',
                'deskripsi' => 'Biaya pembelian furniture',
            ],
            [
                'nama' => 'Biaya Tidak Terduga',
                'deskripsi' => 'Biaya diluar pengeluaran perbulan',
            ],
            [
                'nama' => 'Biaya Rutin Bulanan',
                'deskripsi' => 'Biaya pengeluaran perbulan',
            ],
            [
                'nama' => 'Biaya Rutin Tauhunan',
                'deskripsi' => 'Biaya pengeluaran pertahun',
            ],
            [
                'nama' => 'Gaji Karyawan',
                'deskripsi' => 'Pengeluaran untuk pembayaran gaji karyawan.',
            ],
            [
                'nama' => 'Perlengkapan',
                'deskripsi' => 'Pembelian perlengkapan kantor atau toko.',
            ],
            [
                'nama' => 'Pemeliharaan',
                'deskripsi' => 'Biaya perawatan dan pemeliharaan aset.',
            ],
            [
                'nama' => 'Lain-lain',
                'deskripsi' => 'Pengeluaran lain yang tidak termasuk kategori di atas.',
            ],
        ];

        foreach ($kategori as $item) {
            KategoriPengeluaran::updateOrCreate(
                ['nama' => $item['nama']],
                ['deskripsi' => $item['deskripsi']]
            );
        }
    }
}
