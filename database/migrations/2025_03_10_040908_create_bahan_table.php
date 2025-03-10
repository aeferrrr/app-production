<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bahan', function (Blueprint $table) {
            $table->id('id_bahan'); // Primary Key (Auto Increment)
            $table->string('kode_bahan', 50)->unique(); // Kode bahan unik
            $table->string('nama_bahan', 100); // Nama bahan
            $table->float('harga_bahan', 15); // Harga bahan pakai FLOAT
            $table->string('satuan', 50); // Satuan bahan (Kg, Pcs, dll)
            $table->timestamps(); // Kolom created_at & updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan');
    }
};
