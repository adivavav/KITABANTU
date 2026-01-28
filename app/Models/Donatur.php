<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    protected $table = 'donatur';
    protected $primaryKey = 'id_donatur';

    protected $fillable = [
        'user_id',
        'nama_donatur',
        'email',
        'no_hp',
        'alamat',
    ];

    public $timestamps = false;
}


