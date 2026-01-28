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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_konfirmasi_pembayaran`(IN `p_id_donasi` INT, IN `p_status` VARCHAR(20), IN `p_tanggal` DATE)
BEGIN
  UPDATE transaksi_pembayaran
  SET status_pembayaran = p_status,
      tanggal_bayar = p_tanggal
  WHERE id_donasi = p_id_donasi;

  UPDATE donasi
  SET status_donasi = p_status
  WHERE id_donasi = p_id_donasi;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_konfirmasi_pembayaran");
    }
};
