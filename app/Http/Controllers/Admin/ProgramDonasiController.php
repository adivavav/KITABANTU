<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramDonasiController extends Controller
{
    public function index(Request $request)
    {
        $data = ProgramDonasi::orderByDesc('id_program')
            ->paginate(10);

        return response()->json($data);
    }

    public function show($id)
    {
        return response()->json(
            ProgramDonasi::findOrFail($id)
        );
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'nama_program'     => 'required',
        'deskripsi'        => 'required',
        'target_dana'      => 'required|numeric',
        'tanggal_mulai'    => 'required|date',
        'tanggal_selesai'  => 'nullable|date',
        'status_program'   => 'required',
        'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data['id_admin'] = session('admin_id');

    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $namaFile = 'program_' . time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('storage/program'), $namaFile);

        $data['foto'] = 'program/' . $namaFile;
    }

    ProgramDonasi::create($data);

    return response()->json([
        'message' => 'Program berhasil ditambahkan'
    ]);
    }

    public function update(Request $request, $id)
{
    $program = ProgramDonasi::findOrFail($id);

    $data = $request->validate([
        'nama_program'     => 'required',
        'deskripsi'        => 'required',
        'target_dana'      => 'required|numeric',
        'tanggal_mulai'    => 'required|date',
        'tanggal_selesai'  => 'nullable|date',
        'status_program'   => 'required',
        'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('foto')) {

        if ($program->foto && file_exists(public_path('storage/' . $program->foto))) {
            unlink(public_path('storage/' . $program->foto));
        }

        $file = $request->file('foto');
        $namaFile = 'program_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('storage/program'), $namaFile);

        $data['foto'] = 'program/' . $namaFile;
    }

    $program->update($data);

    return response()->json([
        'message' => 'Program berhasil diperbarui'
    ]);
        }


    public function destroy($id)
{
    $program = ProgramDonasi::findOrFail($id);

    if ($program->foto && file_exists(public_path('storage/' . $program->foto))) {
        unlink(public_path('storage/' . $program->foto));
    }

    $program->delete();

    return response()->json([
        'message' => 'Program berhasil dihapus'
    ]);

    }
}
