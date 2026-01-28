<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewProgressProgram extends Model
{
    protected $table = 'v_progress_program';
    protected $primaryKey = 'id_program';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];
}
