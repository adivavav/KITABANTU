<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonaturController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $donatur = Donatur::query()
            ->when($q, function ($query) use ($q) {
                $query->where('nama_donatur', 'like', "%$q%")
                      ->orWhere('email', 'like', "%$q%")
                      ->orWhere('no_hp', 'like', "%$q%");
            })
            ->orderByDesc('id_donatur')
            ->paginate(10);

        return view('admin.donatur', compact('donatur', 'q'));
    }

public function store(Request $request)
{
    $data = $request->validate([
        'nama_donatur' => 'required|string|max:100',
        'email'        => 'nullable|email|max:100',
        'no_hp'        => 'nullable|string|max:20',
        'alamat'       => 'nullable|string',
    ]);

    $data['user_id'] = session('admin_id');

    Donatur::create($data);

    return redirect()
        ->route('admin.donatur')
        ->with('success', 'Donatur berhasil ditambahkan');
}

    public function update(Request $request, $id)
    {
        $donatur = Donatur::findOrFail($id);

        $data = $request->validate([
            'nama_donatur' => 'required|string|max:100',
            'email'        => 'nullable|email|max:100',
            'no_hp'        => 'nullable|string|max:20',
            'alamat'       => 'nullable|string',
        ]);

        $donatur->update($data);

        return redirect()
            ->route('admin.donatur')
            ->with('success', 'Donatur berhasil diperbarui');
    }

    public function destroy($id)
    {
        Donatur::findOrFail($id)->delete();

        return redirect()
            ->route('admin.donatur')
            ->with('success', 'Donatur berhasil dihapus');
    }
}
