<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewTotalDonasiProgram extends Model
{
    protected $table = 'v_total_donasi_program';
    protected $primaryKey = 'id_program';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];
}
