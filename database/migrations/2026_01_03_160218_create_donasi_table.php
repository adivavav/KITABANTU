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
        Schema::create('donasi', function (Blueprint $table) {
            $table->integer('id_donasi', true);
            $table->integer('id_donatur')->index('id_donatur');
            $table->integer('id_program')->index('id_program');
            $table->integer('id_metode')->index('id_metode');
            $table->decimal('jumlah_donasi', 15);
            $table->date('tanggal_donasi');
            $table->string('status_donasi', 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
