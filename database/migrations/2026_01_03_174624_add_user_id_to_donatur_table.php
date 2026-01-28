<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('donatur', function (Blueprint $table) {
        // ⚠️ HANYA TAMBAH FOREIGN KEY
        $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');
    });
}



    /**
     * Reverse the migrations.
     */
 public function down()
{
    Schema::table('donatur', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
    });
}


};
