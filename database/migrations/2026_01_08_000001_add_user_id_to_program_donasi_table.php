<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('program_donasi', function (Blueprint $table) {
            if (!Schema::hasColumn('program_donasi', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id_admin');

                // Kalau mau FK (opsional, aman)
                $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('program_donasi', function (Blueprint $table) {
            if (Schema::hasColumn('program_donasi', 'user_id')) {
                // drop foreign dulu kalau ada
                try { $table->dropForeign(['user_id']); } catch (\Throwable $e) {}
                $table->dropColumn('user_id');
            }
        });
    }
};
