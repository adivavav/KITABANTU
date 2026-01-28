<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
{
    return view('admin.dashboard', [
        'totalDonatur' => Donatur::count(),
        'totalAdmin'   => Admin::count(),
        'totalProgram' => ProgramDonasi::count(),
        'totalDonasi'  => Donasi::where('status', 'berhasil')->sum('jumlah'),
        'programAktif' => ProgramDonasi::where('status_program','aktif')->limit(5)->get(),
        'donasiTerbesar' => Donasi::with(['donatur','program'])
            ->where('status','berhasil')
            ->orderByDesc('jumlah')
            ->limit(5)
            ->get(),
    ]);
}

    public function index()
    {
        $admin = Admin::orderBy('id_admin', 'desc')->paginate(10);

        return view('admin.admin', compact('admin'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_admin' => 'required|string|max:100',
            'username'   => 'required|string|max:50|unique:admin,username',
            'password'   => 'required|string|min:5',
        ]);

        $data['password'] = Hash::make($data['password']);

        Admin::create($data);

        return redirect()
            ->route('admin.admin')
            ->with('success', 'Admin berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $data = $request->validate([
            'nama_admin' => 'required|string|max:100',
            'username'   => 'required|string|max:50|unique:admin,username,' . $id . ',id_admin',
            'password'   => 'nullable|string|min:5',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $admin->update($data);

        return redirect()
            ->route('admin.admin')
            ->with('success', 'Admin berhasil diperbarui');
    }

   public function destroy($id)
{
    $admin = Admin::findOrFail($id);

    if ($admin->programDonasi()->exists()) {
        return redirect()
            ->route('admin.admin')
            ->withErrors('Admin tidak bisa dihapus karena masih memiliki program donasi');
    }

    $admin->delete();

    return redirect()
        ->route('admin.admin')
        ->with('success', 'Admin berhasil dihapus');
}

}
