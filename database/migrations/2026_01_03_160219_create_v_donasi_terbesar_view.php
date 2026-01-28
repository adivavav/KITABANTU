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
        DB::statement("CREATE VIEW `v_donasi_terbesar` AS select `d`.`id_donasi` AS `id_donasi`,`d`.`tanggal_donasi` AS `tanggal_donasi`,`d`.`jumlah_donasi` AS `jumlah_donasi`,`dn`.`nama_donatur` AS `nama_donatur`,`p`.`nama_program` AS `nama_program` from ((`db_donasi`.`donasi` `d` join `db_donasi`.`donatur` `dn` on(`dn`.`id_donatur` = `d`.`id_donatur`)) join `db_donasi`.`program_donasi` `p` on(`p`.`id_program` = `d`.`id_program`)) where lcase(`d`.`status_donasi`) in ('sukses','berhasil','lunas') order by `d`.`jumlah_donasi` desc,`d`.`tanggal_donasi` desc");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `v_donasi_terbesar`");
    }
};
