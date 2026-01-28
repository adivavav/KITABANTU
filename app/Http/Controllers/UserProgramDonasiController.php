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
            $pathGambar = $request->file('gambar')->store('program-donasi', 'public');
        }

        $cols = Schema::getColumnListing('program_donasi');

        $pick = function (array $candidates) use ($cols) {
            foreach ($candidates as $c) {
                if (in_array($c, $cols)) return $c;
            }
            return null;
        };

       
        $colJudul      = $pick(['nama_program', 'judul', 'judul_program', 'title', 'nama']);
        $colDeskripsi  = $pick(['deskripsi', 'description', 'detail', 'keterangan']);
        $colTarget     = $pick(['target_dana', 'target_donasi', 'target', 'nominal_target']);
        $colTglMulai   = $pick(['tanggal_mulai', 'tgl_mulai', 'start_date']);
        $colTglSelesai = $pick(['tanggal_selesai', 'tgl_selesai', 'deadline', 'end_date']);
        $colFoto       = $pick(['foto', 'gambar', 'cover', 'image']);
        $colStatus     = $pick(['status_program', 'status', 'publikasi', 'is_active']);
        $colIdAdmin    = $pick(['id_admin']);
        $colKategori   = $pick(['kategori', 'category']);
        $colUserId     = $pick(['user_id']); 

    
        if (!$colJudul || !$colDeskripsi || !$colTarget) {
            abort(500, 'Kolom inti (judul/deskripsi/target) tidak ditemukan di tabel program_donasi.');
        }

        $payload = [];
        $payload[$colJudul] = $data['judul'];
        $payload[$colDeskripsi] = $data['deskripsi'];
        $payload[$colTarget] = $data['target_donasi'];

        if ($colKategori) {
            $payload[$colKategori] = $data['kategori'] ?? null;
        }

       
        if ($colUserId) {
            $payload[$colUserId] = auth()->id();
        }

       
        if ($colTglMulai) {
            $payload[$colTglMulai] = date('Y-m-d');
        }

        
        if ($colTglSelesai) {
            $payload[$colTglSelesai] = $data['tanggal_selesai'] ?? date('Y-m-d', strtotime('+30 days'));
        }

        
        if ($colFoto) {
            $payload[$colFoto] = $pathGambar;
        }

        
        if ($colStatus) {
            $payload[$colStatus] = ($colStatus === 'is_active') ? 0 : 'pending';
        }

        
        if ($colIdAdmin) {
            $payload[$colIdAdmin] = 1;
        }

        ProgramDonasi::create($payload);

        return redirect()
            ->route('user.program_donasi.create')
            ->with('success', 'Program donasi berhasil dibuat. Menunggu verifikasi admin.');
    }

    
    public function riwayat()
    {
        $programs = ProgramDonasi::with('donasi')
            ->where('user_id', auth()->id())
            ->orderByDesc('id_program')
            ->get();

        return view('user.riwayat_program_donasi', compact('programs'));
    }
}
