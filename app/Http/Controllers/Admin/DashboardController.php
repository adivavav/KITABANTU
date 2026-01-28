<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Donatur;
use App\Models\Donasi;
use App\Models\ProgramDonasi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDonatur = Donatur::count();
        $totalAdmin   = Admin::count();
        $totalProgram = ProgramDonasi::count();

        $totalDonasi = Donasi::whereIn('status_donasi', ['sukses', 'berhasil'])
            ->sum('jumlah_donasi');

        $donasiTerbesar = Donasi::with(['donatur','program'])
            ->whereIn('status_donasi', ['sukses','berhasil'])
            ->orderByDesc('jumlah_donasi')
            ->limit(10)
            ->get();

        $programAktif = ProgramDonasi::where('status_program','aktif')
            ->limit(5)
            ->get();

        $donasiSukses  = Donasi::whereIn('status_donasi',['sukses','berhasil'])->count();
        $donasiPending = Donasi::where('status_donasi','pending')->count();
        $donasiGagal   = Donasi::where('status_donasi','gagal')->count();

        $donasiBulanan = Donasi::select(
                DB::raw("DATE_FORMAT(tanggal_donasi,'%Y-%m') as bulan"),
                DB::raw("SUM(jumlah_donasi) as total")
            )
            ->whereIn('status_donasi',['sukses','berhasil'])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $progressProgram = ProgramDonasi::withSum(
                ['donasi as total_terkumpul' => function ($q) {
                    $q->whereIn('status_donasi',['sukses','berhasil']);
                }],
                'jumlah_donasi'
            )
            ->get();

        $totalPerProgram = ProgramDonasi::withSum(
                ['donasi as total_donasi' => function ($q) {
                    $q->whereIn('status_donasi',['sukses','berhasil']);
                }],
                'jumlah_donasi'
            )
            ->get();

        return view('admin.dashboard', compact(
            'totalDonatur',
            'totalAdmin',
            'totalProgram',
            'totalDonasi',
            'donasiTerbesar',
            'programAktif',
            'donasiSukses',
            'donasiPending',
            'donasiGagal',
            'donasiBulanan',
            'progressProgram',
            'totalPerProgram'
        ));
    }
}
