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
        DB::statement("CREATE VIEW `v_dashboard_admin` AS select (select count(0) from `db_donasi`.`donatur`) AS `total_donatur`,(select count(0) from `db_donasi`.`program_donasi`) AS `total_program`,(select count(0) from `db_donasi`.`program_donasi` where lcase(`db_donasi`.`program_donasi`.`status_program`) = 'aktif') AS `program_aktif`,(select coalesce(sum(`db_donasi`.`donasi`.`jumlah_donasi`),0) from `db_donasi`.`donasi` where lcase(`db_donasi`.`donasi`.`status_donasi`) like '%sukses%' or lcase(`db_donasi`.`donasi`.`status_donasi`) like '%berhasil%') AS `total_donasi`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `v_dashboard_admin`");
    }
};
