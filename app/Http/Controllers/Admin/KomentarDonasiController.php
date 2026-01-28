<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KomentarDonasi;
use App\Models\Donasi;
use Illuminate\Http\Request;

class KomentarDonasiController extends Controller
{
    // HALAMAN
    public function index()
    {
        $donasi = Donasi::orderByDesc('id_donasi')->get();
        return view('admin.komentar_donasi', compact('donasi'));
    }

    // DATA (AJAX)
    public function data(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $id_donasi = $request->query('id_donasi');

        $query = KomentarDonasi::with('donasi')
            ->when($id_donasi, fn($x) => $x->where('id_donasi', $id_donasi))
            ->when($q, function ($x) use ($q) {
                $x->where(function ($w) use ($q) {
                    $w->where('nama_pengirim', 'like', "%{$q}%")
                      ->orWhere('isi_komentar', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id_komentar');

        return response()->json($query->paginate(10));
    }

    // TAMBAH
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_donasi'      => 'required|exists:donasi,id_donasi',
            'nama_pengirim'  => 'nullable|string|max:100',
            'isi_komentar'   => 'required|string',
        ]);

        $data['tanggal_komentar'] = now();

        KomentarDonasi::create($data);

        return response()->json(['message' => 'Komentar berhasil ditambahkan']);
    }

    // EDIT
    public function update(Request $request, $id)
    {
        $row = KomentarDonasi::findOrFail($id);

        $data = $request->validate([
            'nama_pengirim' => 'nullable|string|max:100',
            'isi_komentar'  => 'required|string',
        ]);

        $row->update($data);

        return response()->json(['message' => 'Komentar berhasil diperbarui']);
    }

    // HAPUS
    public function destroy($id)
    {
        KomentarDonasi::findOrFail($id)->delete();
        return response()->json(['message' => 'Komentar berhasil dihapus']);
    }
}
