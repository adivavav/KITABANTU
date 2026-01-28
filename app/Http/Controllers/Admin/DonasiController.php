<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Donatur;
use App\Models\ProgramDonasi;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    // HALAMAN
    public function index()
{
    $donatur = Donatur::orderBy('nama_donatur')->get();
    $program = ProgramDonasi::orderBy('id_program','desc')->get(); // FIX
    $metode  = MetodePembayaran::all();

    return view('admin.donasi', compact('donatur','program','metode'));
}


    // DATA (AJAX)
    public function data()
    {
        return response()->json(
            Donasi::with(['donatur','program'])
                ->orderByDesc('id_donasi')
                ->paginate(10)
        );
    }

    // TAMBAH DONASI
    public function store(Request $request)
    {
        $request->validate([
            'id_donatur' => 'required|exists:donatur,id_donatur',
            'id_program' => 'required|exists:program_donasi,id_program',
            'id_metode'  => 'required|exists:metode_pembayaran,id_metode',
            'jumlah_donasi' => 'required|numeric|min:1000',
            'status_donasi' => 'required'
        ]);

        Donasi::create([
            'id_donatur' => $request->id_donatur,
            'id_program' => $request->id_program,
            'id_metode' => $request->id_metode,
            'jumlah_donasi' => $request->jumlah_donasi,
            'tanggal_donasi' => now(),
            'status_donasi' => $request->status_donasi
        ]);

        return response()->json(['message'=>'Donasi berhasil ditambahkan']);
    }

    // EDIT STATUS
    public function update(Request $request, $id)
    {
        Donasi::findOrFail($id)->update([
            'status_donasi' => $request->status_donasi
        ]);

        return response()->json(['message'=>'Status donasi diupdate']);
    }

    // HAPUS
    public function destroy($id)
    {
        Donasi::findOrFail($id)->delete();
        return response()->json(['message'=>'Donasi dihapus']);
    }
}
