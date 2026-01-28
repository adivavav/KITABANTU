<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $adminId = session('admin_id');

        $admin = DB::table('admin')
            ->where('id_admin', $adminId)
            ->first();

        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $adminId = session('admin_id');

        $request->validate([
            'nama_admin' => 'required|string|max:100',
            'username'   => 'required|string|max:100',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $admin = DB::table('admin')
            ->where('id_admin', $adminId)
            ->first();

        $fotoPath = $admin->foto_admin; 

        /* =========================
           UPLOAD FOTO BARU
        ========================= */
        if ($request->hasFile('foto')) {

            if ($fotoPath && file_exists(public_path('storage/' . $fotoPath))) {
                unlink(public_path('storage/' . $fotoPath));
            }

            if (!file_exists(public_path('storage/admin'))) {
                mkdir(public_path('storage/admin'), 0755, true);
            }

            $filename = uniqid() . '_' . $request->file('foto')->getClientOriginalName();

            $request->file('foto')->move(
                public_path('storage/admin'),
                $filename
            );

            $fotoPath = 'admin/' . $filename;
        }

        /* =========================
           UPDATE DATABASE
        ========================= */
        DB::table('admin')->where('id_admin', $adminId)->update([
            'nama_admin' => $request->nama_admin,
            'username'   => $request->username,
            'foto_admin' => $fotoPath,
        ]);

        /* =========================
           UPDATE SESSION
        ========================= */
        session([
            'admin_nama'     => $request->nama_admin,
            'admin_username' => $request->username,
            'admin_foto'     => $fotoPath,
        ]);

        return redirect()
            ->route('admin.profile')
            ->with('success', 'Profil berhasil diupdate');
    }
}
