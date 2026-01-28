<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ProgramDonasiService
{
    public function programAktif()
    {
        $rows = DB::table('program_donasi as p')
            ->select(
                'p.id_program',
                'p.nama_program',
                'p.deskripsi',
                'p.foto',
                'p.target_dana',
                'p.status_program',
                DB::raw("COALESCE(SUM(CASE WHEN d.status_donasi='sukses' THEN d.jumlah_donasi ELSE 0 END),0) as terkumpul")
            )
            ->leftJoin('donasi as d', 'd.id_program', '=', 'p.id_program')
            ->where('p.status_program', 'aktif')
            ->groupBy('p.id_program', 'p.nama_program', 'p.deskripsi', 'p.foto', 'p.target_dana', 'p.status_program')
            ->orderBy('p.id_program', 'desc')
            ->get();

        foreach ($rows as $p) {
            $p->progress = ($p->target_dana > 0)
                ? round(((float)$p->terkumpul / (float)$p->target_dana) * 100, 2)
                : 0;

            if ($p->progress > 100) $p->progress = 100;
        }

        return $rows;
    }

    public function findAktif($id)
    {
        $p = DB::table('program_donasi as p')
            ->select(
                'p.id_program',
                'p.nama_program',
                'p.deskripsi',
                'p.foto',
                'p.target_dana',
                'p.status_program',
                DB::raw("COALESCE(SUM(CASE WHEN d.status_donasi='sukses' THEN d.jumlah_donasi ELSE 0 END),0) as terkumpul")
            )
            ->leftJoin('donasi as d', 'd.id_program', '=', 'p.id_program')
            ->where('p.id_program', $id)
            ->where('p.status_program', 'aktif')
            ->groupBy('p.id_program', 'p.nama_program', 'p.deskripsi', 'p.foto', 'p.target_dana', 'p.status_program')
            ->first();

        if ($p) {
            $p->progress = ($p->target_dana > 0)
                ? round(((float)$p->terkumpul / (float)$p->target_dana) * 100, 2)
                : 0;

            if ($p->progress > 100) $p->progress = 100;
        }

        return $p;
    }
}
