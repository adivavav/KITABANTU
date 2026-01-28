<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarDonasi extends Model
{
    protected $table = 'komentar_donasi';
    protected $primaryKey = 'id_komentar';
    public $timestamps = false;

    protected $fillable = [
        'id_donasi',
        'nama_pengirim',
        'isi_komentar',
        'tanggal_komentar',
    ];

    public function donasi()
    {
        return $this->belongsTo(Donasi::class, 'id_donasi', 'id_donasi');
    }
}
