<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewProgramAktif extends Model
{
    protected $table = 'v_program_aktif';
    protected $primaryKey = 'id_program';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];
}
