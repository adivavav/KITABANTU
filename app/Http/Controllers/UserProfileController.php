<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('frontend.profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'  => ['required','string','max:100'],
            'phone' => ['nullable','string','max:20'],
        ]);

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'photo' => ['required','image','mimes:jpg,jpeg,png','max:2048'],
    ]);

    if ($user->photo && Storage::disk('public')->exists($user->photo)) {
        Storage::disk('public')->delete($user->photo);
    }

    $path = $request->file('photo')->store('users', 'public');

    $user->update([
        'photo' => $path,
    ]);

    Auth::setUser($user->fresh());

    return back()->with('success', 'Foto profil berhasil diperbarui.');
}
}
