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
        Schema::table('komentar_donasi', function (Blueprint $table) {
            $table->foreign(['id_donasi'], 'fk_kom_donasi')->references(['id_donasi'])->on('donasi')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_donasi'], 'komentar_donasi_ibfk_1')->references(['id_donasi'])->on('donasi')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komentar_donasi', function (Blueprint $table) {
            $table->dropForeign('fk_kom_donasi');
            $table->dropForeign('komentar_donasi_ibfk_1');
        });
    }
};
