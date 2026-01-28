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
        Schema::create('program_donasi', function (Blueprint $table) {
            $table->integer('id_program', true);
            $table->integer('id_admin')->index('id_admin');
            $table->string('nama_program', 150);
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->decimal('target_dana', 15);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('status_program', 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_donasi');
    }
};
