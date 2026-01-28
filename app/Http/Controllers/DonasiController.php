<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Komentar;
use Illuminate\Support\Facades\DB;



class DonasiController extends Controller
{
public function store(Request $request, $id)
{
    $request->validate([
        'jumlah_donasi' => 'required|numeric|min:1000',
        'id_metode'     => 'required|integer',
        'alamat'        => 'nullable|string',
        'komentar'      => 'nullable|string',
    ]);

    DB::beginTransaction();

    try {
       
        $donaturId = DB::table('donatur')->insertGetId([
            'id_user'    => auth()->id(),
            'alamat'     => $request->alamat,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

       
        $donasiId = DB::table('donasi')->insertGetId([
            'id_donatur'     => $donaturId,
            'id_program'     => $id,
            'jumlah_donasi'  => $request->jumlah_donasi,
            'status_donasi'  => 'pending',
            'tanggal_donasi' => now(),
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        
        if ($request->filled('komentar')) {
            DB::table('komentar_donasi')->insert([
                'id_donasi'  => $donasiId,
                'komentar'   => $request->komentar,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

       
        DB::table('transaksi_pembayaran')->insert([
            'id_donasi'   => $donasiId,
            'id_metode'   => $request->id_metode,
            'status'      => 'pending',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::commit();

        return redirect()
            ->route('donasi.sukses', $idDonasi)
            ->with('success', 'Donasi berhasil dibuat');

    } catch (\Throwable $e) {
        DB::rollBack();

        return back()
            ->withInput()
            ->withErrors('Donasi gagal: '.$e->getMessage());
    }
}


   public function struk($id)
{
    $donasi = Donasi::with(['program','donatur','metode','transaksi'])
        ->where('id_donasi', $id)
        ->firstOrFail();

    if ($donasi->donatur->user_id !== Auth::id()) {
        abort(403);
    }

    
    $transaksi = $donasi->transaksi->last();

    return view('frontend.donasi_struk', compact('donasi','transaksi'));
}

}


