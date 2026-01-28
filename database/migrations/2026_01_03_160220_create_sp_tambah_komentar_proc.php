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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_komentar`(IN `p_id_donasi` INT, IN `p_nama` VARCHAR(100), IN `p_isi` TEXT, IN `p_tanggal` DATE)
BEGIN
  INSERT INTO komentar_donasi
  VALUES (NULL, p_id_donasi, p_nama, p_isi, p_tanggal);
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_tambah_komentar");
    }
};
