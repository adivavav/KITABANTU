<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasi';
    protected $primaryKey = 'id_donasi';
    public $timestamps = false;

    protected $fillable = [
        'id_donatur',
        'id_program',
        'id_metode',
        'jumlah_donasi',
        'tanggal_donasi',
        'status_donasi',
    ];

    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'id_donatur', 'id_donatur');
    }

    public function program()
    {
        return $this->belongsTo(ProgramDonasi::class, 'id_program', 'id_program');
    }

    public function transaksi()
    {
        return $this->hasMany(TransaksiPembayaran::class, 'id_donasi', 'id_donasi');
    }

    public function metode()
{
    return $this->belongsTo(\App\Models\MetodePembayaran::class, 'id_metode', 'id_metode');
}

}
