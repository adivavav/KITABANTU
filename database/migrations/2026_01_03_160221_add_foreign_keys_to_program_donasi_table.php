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
        Schema::table('program_donasi', function (Blueprint $table) {
            $table->foreign(['id_admin'], 'program_donasi_ibfk_1')->references(['id_admin'])->on('admin')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_donasi', function (Blueprint $table) {
            $table->dropForeign('program_donasi_ibfk_1');
        });
    }
};
