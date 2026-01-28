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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reset_transaksi_pending`()
BEGIN
  UPDATE transaksi_pembayaran
  SET status_pembayaran = 'Gagal'
  WHERE status_pembayaran = 'Pending';
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_reset_transaksi_pending");
    }
};
