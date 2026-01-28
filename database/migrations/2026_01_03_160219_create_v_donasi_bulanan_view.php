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
        DB::statement("CREATE VIEW `v_donasi_bulanan` AS select year(`d`.`tanggal_donasi`) AS `tahun`,month(`d`.`tanggal_donasi`) AS `bulan`,date_format(`d`.`tanggal_donasi`,'%Y-%m') AS `periode`,sum(`d`.`jumlah_donasi`) AS `total_donasi` from `db_donasi`.`donasi` `d` where lcase(`d`.`status_donasi`) in ('sukses','berhasil') group by year(`d`.`tanggal_donasi`),month(`d`.`tanggal_donasi`),date_format(`d`.`tanggal_donasi`,'%Y-%m') order by year(`d`.`tanggal_donasi`),month(`d`.`tanggal_donasi`)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `v_donasi_bulanan`");
    }
};
