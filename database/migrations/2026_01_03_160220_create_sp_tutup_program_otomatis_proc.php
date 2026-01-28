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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tutup_program_otomatis`()
BEGIN
  UPDATE program_donasi
  SET status_program = 'Selesai'
  WHERE status_program = 'Aktif'
    AND tanggal_selesai IS NOT NULL
    AND CURRENT_DATE > tanggal_selesai;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_tutup_program_otomatis");
    }
};
