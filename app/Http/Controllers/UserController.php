<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar admin dan form tambah
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('components.manager.kelola-admin', compact('admins'));
    }
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Admin berhasil dihapus');
    }
    // Menyimpan akun admin baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Otomatis set sebagai admin
        ]);

        return redirect()->back()->with('success', 'Akun Admin berhasil dibuat!');
    }
}
