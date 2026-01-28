<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        $data = MetodePembayaran::orderBy('id_metode','desc')->get();
        return view('admin.metode', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_metode' => 'required|max:50',
            'keterangan' => 'nullable|max:100'
        ]);

        MetodePembayaran::create($request->all());

        return redirect()
            ->route('admin.metode')
            ->with('success','Metode berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_metode' => 'required|max:50',
            'keterangan' => 'nullable|max:100'
        ]);

        MetodePembayaran::findOrFail($id)
            ->update($request->all());

        return redirect()
            ->route('admin.metode')
            ->with('success','Metode berhasil diperbarui');
    }

    public function destroy($id)
    {
        MetodePembayaran::findOrFail($id)->delete();

        return redirect()
            ->route('admin.metode')
            ->with('success','Metode berhasil dihapus');
    }
    public function data(Request $request)
{
    $q = $request->q;

    $data = MetodePembayaran::when($q, function($x) use ($q){
            $x->where('nama_metode','like',"%$q%")
              ->orWhere('keterangan','like',"%$q%");
        })
        ->orderByDesc('id_metode')
        ->paginate(10);

    return response()->json($data);
}

}
