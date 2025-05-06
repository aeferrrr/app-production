<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_user');
            $table->decimal('upah', 15, 2);
            $table->timestamps();
        
            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal_produksi')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_user');
    }
};
