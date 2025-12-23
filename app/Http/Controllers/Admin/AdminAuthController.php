<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        // Jika sudah login dan dia admin, langsung ke dashboard
        if (Auth::check() && Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Cek apakah yang login adalah ADMIN
            if (Auth::user()->role == 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('/admin');
            }

            // Jika bukan admin, kita logout-kan lagi
            Auth::logout();
            return back()->withErrors(['email' => 'Maaf Sultan, Anda bukan Admin.']);
        }

        return back()->withErrors(['email' => 'Email atau Password salah!']);
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}