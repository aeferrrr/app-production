<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jadwal_overhead', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_bop');
            $table->integer('biaya')->nullable(); // kalau null, bisa fallback ke biaya_bop di tabel overhead
            $table->timestamps();
        
            // foreign key-nya HARUS ke id_jadwal, bukan id
            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal_produksi')->onDelete('cascade');
            $table->foreign('id_bop')->references('id_bop')->on('overhead')->onDelete('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_overhead');
    }
};
