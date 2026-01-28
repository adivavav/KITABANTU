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
        DB::statement("CREATE VIEW `v_donasi_lengkap` AS select `d`.`id_donasi` AS `id_donasi`,`dn`.`nama_donatur` AS `nama_donatur`,`p`.`nama_program` AS `nama_program`,`mp`.`nama_metode` AS `nama_metode`,`d`.`jumlah_donasi` AS `jumlah_donasi`,`d`.`tanggal_donasi` AS `tanggal_donasi`,`d`.`status_donasi` AS `status_donasi` from (((`db_donasi`.`donasi` `d` join `db_donasi`.`donatur` `dn` on(`d`.`id_donatur` = `dn`.`id_donatur`)) join `db_donasi`.`program_donasi` `p` on(`d`.`id_program` = `p`.`id_program`)) join `db_donasi`.`metode_pembayaran` `mp` on(`d`.`id_metode` = `mp`.`id_metode`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `v_donasi_lengkap`");
    }
};
