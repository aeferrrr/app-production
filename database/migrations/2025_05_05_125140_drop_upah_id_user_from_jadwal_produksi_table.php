
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_produksi', function (Blueprint $table) {
            // Lepas dulu ikatan toxic FK-nya
            $table->dropForeign(['id_user']); // ⬅️ ini wajib!

            // Baru drop kolomnya
            $table->dropColumn(['upah', 'id_user']);
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_produksi', function (Blueprint $table) {
            $table->decimal('upah', 15, 2)->nullable();
            $table->unsignedBigInteger('id_user')->nullable();

            // Balikin FK-nya kalo rollback
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
