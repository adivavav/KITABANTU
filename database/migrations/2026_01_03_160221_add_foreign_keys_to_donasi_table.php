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
        Schema::table('donasi', function (Blueprint $table) {
            $table->foreign(['id_donatur'], 'donasi_ibfk_1')->references(['id_donatur'])->on('donatur')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_program'], 'donasi_ibfk_2')->references(['id_program'])->on('program_donasi')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_metode'], 'donasi_ibfk_3')->references(['id_metode'])->on('metode_pembayaran')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->dropForeign('donasi_ibfk_1');
            $table->dropForeign('donasi_ibfk_2');
            $table->dropForeign('donasi_ibfk_3');
        });
    }
};
