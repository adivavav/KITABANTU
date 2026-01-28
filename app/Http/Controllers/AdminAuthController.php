<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

   public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $admin = Admin::where('username', $request->username)->first();

    if (!$admin || !Hash::check($request->password, $admin->password)) {
        return back()->with('error', 'Login gagal');
    }

    
    session([
        'admin_id'       => $admin->id_admin,
        'admin_nama'     => $admin->nama_admin,
        'admin_username' => $admin->username,
        'admin_foto' => $admin->foto_admin,
    ]);

    return redirect('/admin/dashboard');
}


   public function logout()
{
    session()->forget(['admin_id','admin_nama','admin_username']);
    session()->flush(); 

    return redirect('/admin/login')->with('success', 'Berhasil logout.');
}

    }

