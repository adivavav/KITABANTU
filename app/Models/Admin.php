<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramDonasi;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = [
        'nama_admin',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function programDonasi()
    {
        return $this->hasMany(ProgramDonasi::class, 'id_admin');
    }
}
