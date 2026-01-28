<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramDonasi;

class RiwayatProgramDonasiSaya extends Controller
{
    public function index()
    {
       
        $programs = ProgramDonasi::with('donasi')
            ->where('user_id', auth()->id())
            ->orderByDesc('id_program')
            ->get();

        return view('user.riwayat_program', compact('programs'));
    }
}
