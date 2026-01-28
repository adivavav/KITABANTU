<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramDonasi extends Model
{
    protected $table = 'program_donasi';
    protected $primaryKey = 'id_program';
    public $timestamps = false;

    protected $fillable = [
        'id_admin',
        'nama_program',
        'deskripsi',
        'target_dana',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_program',
        'foto'
    ];

    public function donasi()
    {
        return $this->hasMany(
            Donasi::class,
            'id_program',
            'id_program'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
