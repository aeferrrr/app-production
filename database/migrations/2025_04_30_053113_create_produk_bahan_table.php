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
        Schema::create('produk_bahan', function (Blueprint $table) {
            $table->id('id_produk_bahan');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_bahan');
            $table->decimal('jumlah_bahan', 10, 2);
            $table->string('satuan', 10);
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_bahan')->references('id_bahan')->on('bahan')->onDelete('cascade');

            // Optional: biar gak ada data duplikat
            $table->unique(['id_produk', 'id_bahan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_bahan');
    }
};
