<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
{
    // Sesuaikan dengan struktur folder: auth -> passwords -> profile
    return view('auth.passwords.profile', [
        'pageTitle' => 'My Profile'
    ]);
}

   public function update(Request $request)
{
    $user = auth()->user();

    // Logika upload foto (jika ada)
    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    $user->name = $request->name;
    $user->email = $request->email;
    $user->save(); // Ini akan memperbarui data di database

    return back()->with('status', 'Profil berhasil diperbarui!');
}

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Password changed successfully!');
    }
}
