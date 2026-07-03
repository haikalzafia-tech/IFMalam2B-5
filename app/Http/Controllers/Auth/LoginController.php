<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Penting ditambahkan

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override fungsi authenticated agar bisa mengirim notifikasi
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended($this->redirectTo)
                        ->with('success', 'Selamat datang kembali, ' . $user->name . '! Anda berhasil masuk ke sistem.');
    }
}