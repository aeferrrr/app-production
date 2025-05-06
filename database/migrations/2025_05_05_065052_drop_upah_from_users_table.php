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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('upah');
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('upah', 10, 2)->nullable(); // Kalau perlu rollback
        });
    }
    
};
