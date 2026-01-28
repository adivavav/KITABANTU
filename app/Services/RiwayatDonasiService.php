<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RiwayatDonasiService
{
    public static function get(array $filter = [])
    {
        $query = DB::table('v_riwayat_donatur');

        if (!empty($filter['email'])) {
            $query->where('email', $filter['email']);
        }

        if (!empty($filter['status'])) {
            $query->where('status_donasi', $filter['status']);
        }

        return $query
            ->orderByDesc('tanggal_donasi')
            ->get();
    }
}
