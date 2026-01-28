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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_status_program`(IN `p_id_program` INT, IN `p_status` VARCHAR(20))
BEGIN
  UPDATE program_donasi
  SET status_program = p_status
  WHERE id_program = p_id_program;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_update_status_program");
    }
};
