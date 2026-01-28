<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewDonasiTerbesar extends Model
{
    protected $table = 'v_donasi_terbesar';
    protected $primaryKey = 'id_donasi';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];
}
