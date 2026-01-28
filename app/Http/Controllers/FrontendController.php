<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\RiwayatDonasiService;
use App\Services\ProgramDonasiService;
use App\Models\MetodePembayaran;
use App\Models\Donasi;



class FrontendController extends Controller
{
   public function home()
{
    $programAktif = DB::table('program_donasi')
        ->where('status_program', 'aktif')
        ->get();

    $programUnggulan = DB::table('program_donasi')
        ->where('status_program', 'aktif')
        ->orderByDesc('target_dana')
        ->limit(3)
        ->get();

    return view('frontend.home', compact(
        'programAktif',
        'programUnggulan'
    ));
}


    
public function donasi(\App\Services\ProgramDonasiService $service)
{
    $programs = $service->programAktif();
    return view('frontend.donasi.index', compact('programs'));
}

public function donasiDetail($id, ProgramDonasiService $service)
{
    
    $program = $service->findAktif($id);
    abort_if(!$program, 404);

    $metode = \App\Models\MetodePembayaran::all();

    return view('frontend.donasi.detail', compact('program', 'metode'));
}

public function donasiStore(Request $request, $id)
{
    $request->validate([
        'jumlah_donasi' => 'required|numeric|min:1000',
        'id_metode'     => 'required|integer',
    ]);

    DB::beginTransaction();

    try {
        $user = Auth::user();

       
        DB::table('donatur')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'nama_donatur' => $user->name,
                'email'        => $user->email,
                'no_hp'        => $user->phone ?? null,
                'alamat'       => $request->alamat,
            ]
        );

        $idDonatur = DB::table('donatur')
            ->where('user_id', $user->id)
            ->value('id_donatur');

        
        $idDonasi = DB::table('donasi')->insertGetId([
            'id_program'     => $id,
            'id_donatur'     => $idDonatur,
            'id_metode'      => $request->id_metode,
            'jumlah_donasi'  => $request->jumlah_donasi,
            'tanggal_donasi' => now(),
            'status_donasi'  => 'pending',
        ]);

        
        DB::table('transaksi_pembayaran')->insert([
            'id_donasi'          => $idDonasi,
            'metode_pembayaran'  => DB::table('metode_pembayaran')
                                        ->where('id_metode', $request->id_metode)
                                        ->value('nama_metode'),
            'tanggal_bayar'      => now()->toDateString(),
            'status_pembayaran'  => 'pending',
        ]);

        
        if ($request->filled('komentar')) {
            DB::table('komentar_donasi')->insert([
                'id_donasi'        => $idDonasi,
                'nama_pengirim'    => $user->name,
                'isi_komentar'     => $request->komentar,
                'tanggal_komentar' => now()->toDateString(),
            ]);
        }

        DB::commit();

        return redirect()
            ->route('donasi.sukses', $idDonasi)
            ->with('success', 'Donasi berhasil dibuat & menunggu verifikasi admin');

    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->withErrors(['Donasi gagal: '.$e->getMessage()]);
    }
}


   public function donasiSukses($id)
{
    $donasi = Donasi::with(['program','donatur','metode','transaksi'])
        ->where('id_donasi', $id)
        ->firstOrFail();

    return view('frontend.donasi_sukses', compact('donasi'));
}




   public function donatur()
{
    $donations = DB::table('donasi')
        ->join('donatur', 'donasi.id_donatur', '=', 'donatur.id_donatur')
        ->join('program_donasi', 'donasi.id_program', '=', 'program_donasi.id_program')
        ->select([
            'donatur.nama_donatur',
            'program_donasi.nama_program',
            'donasi.jumlah_donasi',
            'donasi.tanggal_donasi',
            'donasi.status_donasi',
        ])
        ->orderByDesc('donasi.tanggal_donasi')
        ->get();

    return view('frontend.donatur', compact('donations'));
}


   public function riwayatDonasi()
{
    $user = Auth::user();

   $riwayat = DB::table('donasi')
    ->join('donatur', 'donasi.id_donatur', '=', 'donatur.id_donatur')
    ->join('program_donasi', 'donasi.id_program', '=', 'program_donasi.id_program')
    ->where('donatur.user_id', $user->id)
    ->select([
        'donasi.id_donasi',
        'donasi.tanggal_donasi as tanggal',
        'program_donasi.nama_program as program',
        'donasi.jumlah_donasi as jumlah',
        'donasi.status_donasi as status'
    ])
    ->orderByDesc('donasi.tanggal_donasi')
    ->get();


    return view('frontend.riwayat-donasi', compact('riwayat'));
}

    public function tentangKami()
    {
         return view('frontend.tentang_kami');
    }


}
