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
        Schema::create('overhead', function (Blueprint $table) {
            $table->id('id_bop');
            $table->string('nama_bop', 100);
            $table->float('biaya_bop', 15);
            $table->string('keterangan_bop', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overhead');
    }
};
