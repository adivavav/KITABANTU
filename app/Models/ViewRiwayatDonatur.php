<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewRiwayatDonatur extends Model
{
    protected $table = 'v_riwayat_donatur';
    public $timestamps = false;

    // view tidak punya PK bawaan, tapi kita bisa pakai id_donasi sebagai identifier
    protected $primaryKey = 'id_donasi';
    public $incrementing = false;
}
