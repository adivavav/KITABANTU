<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\ProgramDonasi;

class UserProgramDonasiController extends Controller
{
    public function create()
    {
        return view('user.program_donasi.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'           => 'required|string|max:150',
            'ringkasan'       => 'nullable|string|max:255',
            'deskripsi'       => 'required|string|min:20',
            'kategori'        => 'nullable|string|max:50',
            'target_donasi'   => 'required|integer|min:1000',
            'tanggal_selesai' => 'nullable|date|after_or_equal:today',
            'gambar'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $request->file('gambar')
                ->store('program-donasi', 'public');
        }

        $cols = Schema::getColumnListing('program_donasi');

        $pick = function (array $candidates) use ($cols) {
            foreach ($candidates as $c) {
                if (in_array($c, $cols)) return $c;
            }
            return null;
        };

        $colJudul      = $pick(['judul', 'nama_program', 'judul_program']);
        $colDeskripsi  = $pick(['deskripsi']);
        $colTarget     = $pick(['target_donasi', 'target_dana']);
        $colKategori   = $pick(['kategori']);
        $colTglMulai   = $pick(['tanggal_mulai']);
        $colTglSelesai = $pick(['tanggal_selesai']);
        $colFoto       = $pick(['gambar', 'foto']);
        $colStatus     = $pick(['status', 'status_program']);
        $colUserId     = $pick(['user_id', 'id_user', 'created_by']);
        $colAdminId    = $pick(['id_admin']);

        if (!$colJudul || !$colDeskripsi || !$colTarget) {
            abort(500, 'Kolom inti tidak ditemukan di tabel program_donasi.');
        }

        $payload = [
            $colJudul     => $data['judul'],
            $colDeskripsi => $data['deskripsi'],
            $colTarget    => $data['target_donasi'],
        ];

        if ($colKategori)   $payload[$colKategori] = $data['kategori'];
        if ($colUserId)     $payload[$colUserId]   = auth()->id();
        if ($colTglMulai)   $payload[$colTglMulai] = now()->toDateString();
        if ($colTglSelesai) $payload[$colTglSelesai] =
            $data['tanggal_selesai'] ?? now()->addDays(30)->toDateString();
        if ($colFoto)       $payload[$colFoto] = $pathGambar;
        if ($colStatus)     $payload[$colStatus] = 'pending';
        if ($colAdminId)    $payload[$colAdminId] = 1;

        ProgramDonasi::create($payload);

        return redirect()
            ->route('user.program_donasi.create')
            ->with('success', 'Program berhasil dibuat dan menunggu verifikasi admin.');
    }

    public function riwayat()
    {
        $cols = Schema::getColumnListing('program_donasi');

        $pick = function (array $candidates) use ($cols) {
            foreach ($candidates as $c) {
                if (in_array($c, $cols)) return $c;
            }
            return null;
        };

        $colUserId = $pick(['user_id', 'id_user', 'created_by']);

        if (!$colUserId) {
            abort(500, 'Kolom user_id tidak ditemukan untuk riwayat program.');
        }

        $programs = ProgramDonasi::with('donasi')
            ->where($colUserId, auth()->id())
            ->orderByDesc('id_program')
            ->get();

        return view('user.riwayat_program_donasi', compact('programs'));
    }
}
