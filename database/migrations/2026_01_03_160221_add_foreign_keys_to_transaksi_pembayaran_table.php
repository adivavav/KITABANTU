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
        Schema::table('transaksi_pembayaran', function (Blueprint $table) {
            $table->foreign(['id_donasi'], 'fk_trx_donasi')->references(['id_donasi'])->on('donasi')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_donasi'], 'transaksi_pembayaran_ibfk_1')->references(['id_donasi'])->on('donasi')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_pembayaran', function (Blueprint $table) {
            $table->dropForeign('fk_trx_donasi');
            $table->dropForeign('transaksi_pembayaran_ibfk_1');
        });
    }
};
