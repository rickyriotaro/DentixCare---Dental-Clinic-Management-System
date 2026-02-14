<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if ($userRole !== $role) {
            // auto arahkan ke dashboard sesuai role
            if ($userRole === 'admin') {
                return redirect()->route('dashboard');
            }
            if ($userRole === 'dokter') {
                return redirect()->route('dokter.dashboard');
            }

            abort(403, 'AKSES DITOLAK.');
        }

        return $next($request);
    }
}
