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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buat_donasi`(IN `p_id_donatur` INT, IN `p_id_program` INT, IN `p_id_metode` INT, IN `p_jumlah` DECIMAL(15,2), IN `p_tanggal` DATE)
BEGIN
  INSERT INTO donasi
  VALUES (NULL, p_id_donatur, p_id_program, p_id_metode,
          p_jumlah, p_tanggal, 'Pending');

  INSERT INTO transaksi_pembayaran
  VALUES (NULL, LAST_INSERT_ID(), 'Transfer Bank', NULL, 'Pending');
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_buat_donasi");
    }
};
