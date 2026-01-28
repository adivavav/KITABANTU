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
        DB::statement("CREATE VIEW `v_progress_program` AS select `p`.`id_program` AS `id_program`,`p`.`nama_program` AS `nama_program`,`p`.`target_dana` AS `target_dana`,coalesce(sum(`d`.`jumlah_donasi`),0) AS `total_terkumpul`,round(coalesce(sum(`d`.`jumlah_donasi`),0) / nullif(`p`.`target_dana`,0) * 100,2) AS `persentase_pencapaian`,`p`.`status_program` AS `status_program` from (`db_donasi`.`program_donasi` `p` left join `db_donasi`.`donasi` `d` on(`p`.`id_program` = `d`.`id_program` and lcase(`d`.`status_donasi`) = 'sukses')) group by `p`.`id_program`,`p`.`nama_program`,`p`.`target_dana`,`p`.`status_program`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `v_progress_program`");
    }
};
