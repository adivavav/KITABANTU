<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| FRONTEND (PUBLIC)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/donasi', [FrontendController::class, 'donasi'])->name('donasi');
Route::get('/donatur', [FrontendController::class, 'donatur'])->name('donatur.list');
Route::get('/tentang_kami', [FrontendController::class, 'tentangKami'])->name('tentang.kami');

Route::get('/donasi/{id}', [FrontendController::class, 'donasiDetail'])
    ->name('donasi.detail');

Route::post('/donasi/{id}/store', [FrontendController::class, 'donasiStore'])
    ->middleware('auth')
    ->name('donasi.store');

Route::get('/donasi/{id}/sukses', [FrontendController::class, 'donasiSukses'])
    ->name('donasi.sukses');

/*
|--------------------------------------------------------------------------
| AUTH USER
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\UserAuthController;

Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.post');
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [UserAuthController::class, 'register'])->name('register.post');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

/*
|--------------------------------------------------------------------------
| USER AREA (AUTH)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserProgramDonasiController;
use App\Http\Controllers\DonasiController; // FRONTEND


Route::middleware('auth')->group(function () {

    // PROFIL USER
    Route::get('/profil', [UserProfileController::class, 'index'])->name('user.profile');
    Route::post('/profil', [UserProfileController::class, 'update'])->name('user.profile.update');
    Route::post('/profil/foto', [UserProfileController::class, 'updatePhoto'])->name('user.profile.photo');

    // PROGRAM DONASI USER
    Route::get('/program-donasi/buat', [UserProgramDonasiController::class, 'create'])
        ->name('user.program_donasi.create');
    Route::post('/program-donasi/store', [UserProgramDonasiController::class, 'store'])
        ->name('user.program_donasi.store');

    Route::get('/riwayat-program-donasi', [UserProgramDonasiController::class, 'riwayat'])
        ->name('user.program_donasi.riwayat');

    Route::get('/riwayat-donasi', [FrontendController::class, 'riwayatDonasi'])
        ->name('riwayat.donasi');

    // STRUK DONASI
    Route::get('/donasi/struk/{id}', [DonasiController::class, 'struk'])
        ->name('donasi.struk');
});

/*
|--------------------------------------------------------------------------
| AUTH ADMIN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AdminAuthController;

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA (PROTECTED, FULL WEB)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonaturController;
use App\Http\Controllers\Admin\ProgramDonasiController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KomentarDonasiController;
use App\Http\Controllers\Admin\MetodePembayaranController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\Admin\TransaksiPembayaranController;
use App\Http\Controllers\Admin\DonasiController as AdminDonasiController;




Route::prefix('admin')->middleware('admin.auth')->group(function () {

    Route::get('/', fn () => redirect('/admin/dashboard'))->name('admin.root');

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.admin');
    Route::get('/donatur', [DonaturController::class, 'index'])->name('admin.donatur');
    Route::get('/program', [ProgramDonasiController::class, 'index'])->name('admin.program');



    /*
    |--------------------------------------------------------------------------
    | MASTER DATA (CRUD WEB)
    |--------------------------------------------------------------------------
    */

    // ADMIN
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.admin');

    Route::post('/admin', [AdminController::class, 'store'])
        ->name('admin.admin.store');

    Route::put('/admin/{id}', [AdminController::class, 'update'])
        ->name('admin.admin.update');

    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])
        ->name('admin.admin.destroy');

        // USERS (ADMIN)
   Route::get('/users', [UserController::class, 'index'])
        ->name('admin.users');

    Route::post('/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    Route::post('/users/{id}', [UserController::class, 'update'])
        ->name('admin.users.update');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');



    // DONATUR
     Route::get('/donatur', [DonaturController::class, 'index'])
        ->name('admin.donatur');

    Route::post('/donatur', [DonaturController::class, 'store'])
        ->name('admin.donatur.store');

    Route::put('/donatur/{id}', [DonaturController::class, 'update'])
        ->name('admin.donatur.update');

    Route::delete('/donatur/{id}', [DonaturController::class, 'destroy'])
        ->name('admin.donatur.destroy');

    // PROGRAM DONASI
     Route::get('/program', function () {
        return view('admin.program');
    })->name('admin.program');

    // ======================
    // DATA (AJAX / JSON)
    // ======================
    Route::get('/program/data', [ProgramDonasiController::class, 'index']);
    Route::get('/program/{id}', [ProgramDonasiController::class, 'show']);
    Route::post('/program', [ProgramDonasiController::class, 'store']);
    Route::post('/program/{id}', [ProgramDonasiController::class, 'update']);
    Route::delete('/program/{id}', [ProgramDonasiController::class, 'destroy']);

    //donasi
      Route::get('/donasi', [AdminDonasiController::class, 'index'])
        ->name('admin.donasi');

    Route::get('/donasi/data', [AdminDonasiController::class, 'data']);

    Route::post('/donasi', [AdminDonasiController::class, 'store']);

    Route::get('/donasi/{id}', [AdminDonasiController::class, 'show']);

    Route::post('/donasi/{id}', [AdminDonasiController::class, 'update']);

    Route::delete('/donasi/{id}', [AdminDonasiController::class, 'destroy']);


    // KOMENTAR
    Route::get('/komentar', [KomentarDonasiController::class, 'index'])
        ->name('admin.komentar');

    Route::get('/komentar/data', [KomentarDonasiController::class, 'data']);

    Route::post('/komentar', [KomentarDonasiController::class, 'store']);

    Route::post('/komentar/{id}', [KomentarDonasiController::class, 'update']);

    Route::delete('/komentar/{id}', [KomentarDonasiController::class, 'destroy']);

    //transaksi pembayaran
    Route::get('/transaksi-pembayaran', [TransaksiPembayaranController::class,'index'])
    ->name('admin.transaksi_pembayaran');

Route::get('/transaksi-pembayaran/data', [TransaksiPembayaranController::class,'data']);

Route::post('/transaksi-pembayaran', [TransaksiPembayaranController::class,'store']);

Route::post('/transaksi-pembayaran/{id}', [TransaksiPembayaranController::class,'update']);

Route::delete('/transaksi-pembayaran/{id}', [TransaksiPembayaranController::class,'destroy']);

Route::post('/transaksi-pembayaran/konfirmasi/{id_donasi}',
    [TransaksiPembayaranController::class,'konfirmasi'])
    ->name('admin.transaksi.konfirmasi');

    // METODE PEMBAYARAN
    

    Route::get('/metode', [MetodePembayaranController::class,'index'])
        ->name('admin.metode');

    Route::post('/metode', [MetodePembayaranController::class,'store'])
        ->name('admin.metode.store');

    Route::post('/metode/{id}', [MetodePembayaranController::class,'update'])
        ->name('admin.metode.update');

    Route::delete('/metode/{id}', [MetodePembayaranController::class,'destroy'])
        ->name('admin.metode.destroy');

    // admin profile
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');

    Route::get('/profile', [AdminProfileController::class, 'edit'])
        ->name('admin.profile');

    Route::post('/profile', [AdminProfileController::class, 'update'])
        ->name('admin.profile.update');
});
