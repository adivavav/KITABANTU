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
        DB::statement("CREATE VIEW `v_riwayat_donatur` AS select `dt`.`id_donatur` AS `id_donatur`,`dt`.`nama_donatur` AS `nama_donatur`,`dt`.`email` AS `email`,`d`.`id_donasi` AS `id_donasi`,`p`.`nama_program` AS `nama_program`,`d`.`jumlah_donasi` AS `jumlah_donasi`,`d`.`tanggal_donasi` AS `tanggal_donasi`,`d`.`status_donasi` AS `status_donasi` from ((`db_donasi`.`donatur` `dt` join `db_donasi`.`donasi` `d` on(`d`.`id_donatur` = `dt`.`id_donatur`)) left join `db_donasi`.`program_donasi` `p` on(`p`.`id_program` = `d`.`id_program`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `v_riwayat_donatur`");
    }
};
