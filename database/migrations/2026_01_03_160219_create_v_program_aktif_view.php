<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE VIEW `v_program_aktif` AS select `db_donasi`.`program_donasi`.`id_program` AS `id_program`,`db_donasi`.`program_donasi`.`nama_program` AS `nama_program`,`db_donasi`.`program_donasi`.`status_program` AS `status_program` from `db_donasi`.`program_donasi` where lcase(`db_donasi`.`program_donasi`.`status_program`) = 'aktif'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `v_program_aktif`");
    }
};
