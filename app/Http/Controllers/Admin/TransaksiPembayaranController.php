<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiPembayaran;
use App\Models\Donasi;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiPembayaranController extends Controller
{
    public function index()
    {
        $donasi = Donasi::orderByDesc('id_donasi')->get();
        $metode = MetodePembayaran::orderBy('nama_metode')->get();

        return view('admin.transaksi_pembayaran', compact('donasi','metode'));
    }

    public function data()
    {
        return response()->json(
            TransaksiPembayaran::with('donasi')
                ->orderByDesc('id_transaksi')
                ->paginate(20)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_donasi' => 'required|exists:donasi,id_donasi',
            'metode_pembayaran' => 'required|string|exists:metode_pembayaran,nama_metode',
            'status_pembayaran' => 'required|string|max:20',
            'tanggal_bayar' => 'nullable|date',
        ]);

        TransaksiPembayaran::create($data);

        return response()->json(['message'=>'Transaksi berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $trx = TransaksiPembayaran::findOrFail($id);

        $data = $request->validate([
            'metode_pembayaran' => 'required|string|exists:metode_pembayaran,nama_metode',
            'status_pembayaran' => 'required|string|max:20',
            'tanggal_bayar' => 'nullable|date',
        ]);

        $trx->update($data);

        return response()->json(['message'=>'Transaksi berhasil diupdate']);
    }

    public function destroy($id)
    {
        TransaksiPembayaran::findOrFail($id)->delete();
        return response()->json(['message'=>'Transaksi berhasil dihapus']);
    }

    public function konfirmasi($id_donasi)
    {
        DB::beginTransaction();
        try {
            TransaksiPembayaran::where('id_donasi',$id_donasi)
                ->update([
                    'status_pembayaran'=>'lunas',
                    'tanggal_bayar'=>now()
                ]);

            Donasi::where('id_donasi',$id_donasi)
                ->update(['status_donasi'=>'sukses']);

            DB::commit();
            return back()->with('success','Donasi berhasil dikonfirmasi');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Gagal konfirmasi');
        }
    }
}
