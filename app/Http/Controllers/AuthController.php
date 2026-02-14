<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function process(Request $request)
    {
        $request->validate([
            'role'     => 'required|in:admin,dokter',
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['login' => 'Email atau password salah'])->withInput();
        }

        $user = Auth::user();

        if ($user->role !== $request->role) {
            Auth::logout();
            return back()->withErrors(['login' => 'Role tidak sesuai'])->withInput();
        }

        return $user->role === 'admin'
            ? redirect()->route('dashboard')        // ✅ /dashboard
            : redirect()->route('dokter.dashboard'); // ✅ /dokter/dashboard
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
