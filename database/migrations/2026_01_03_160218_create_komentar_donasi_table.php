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
        Schema::create('komentar_donasi', function (Blueprint $table) {
            $table->integer('id_komentar', true);
            $table->integer('id_donasi')->index('id_donasi');
            $table->string('nama_pengirim', 100)->nullable();
            $table->text('isi_komentar');
            $table->date('tanggal_komentar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_donasi');
    }
};
