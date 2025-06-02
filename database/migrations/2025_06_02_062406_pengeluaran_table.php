<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('kategori_pengeluaran_id')->constrained('kategori_pengeluaran')->onDelete('cascade');
            $table->string('deskripsi'); // contoh: Penjualan, Refund, Diskon
            $table->unsignedBigInteger('jumlah'); // tanpa desimal, simpan angka bulat (misal 150000)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
