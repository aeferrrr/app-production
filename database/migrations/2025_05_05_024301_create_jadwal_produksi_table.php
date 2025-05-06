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
        Schema::create('jadwal_produksi', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->unsignedBigInteger('id_pesanan'); // Menentukan kolom untuk FK secara manual
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade'); // FK ke pesanan
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status_jadwal', ['menunggu', 'berjalan', 'selesai', 'gagal']);
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
        Schema::dropIfExists('jadwal_produksi');
    }
};
