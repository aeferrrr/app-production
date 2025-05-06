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
        Schema::table('jadwal_produksi', function (Blueprint $table) {
            // Tambah kolom id_user dan set sebagai foreign key ke users.id
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
    
            // Tambah kolom upah setelah tanggal_selesai
            $table->decimal('upah', 10, 2)->after('tanggal_selesai')->nullable();
        });
    }
    
    public function down(): void
    {
        Schema::table('jadwal_produksi', function (Blueprint $table) {
            // Hapus foreign key dan kolomnya
            $table->dropForeign(['id_user']);
            $table->dropColumn(['id_user', 'upah']);
        });
    }
    
};
