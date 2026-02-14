<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiAuth extends Controller
{
    /**
     * =====================
     * REGISTER (MOBILE)
     * =====================
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat'       => 'required|string',
            'no_hp'         => 'required|string|max:20',
            'email'        => 'required|email|unique:patients,email',
            'username'     => 'required|string|unique:patients,username',
            'password'     => 'required|min:6',
        ]);

        $patient = Patient::create([
            'nama_lengkap' => $request->nama_lengkap,
            'alamat'       => $request->alamat,
            'no_hp'         => $request->no_hp,
            'email'        => $request->email,
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil',
            'user'    => $patient,
        ], 201)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization');
    }

    /**
     * =====================
     * LOGIN (MOBILE)
     * =====================
     */
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required', // email ATAU username
            'password' => 'required',
        ]);

        $patient = Patient::where('email', $request->login)
            ->orWhere('username', $request->login)
            ->first();

        if (!$patient || !Hash::check($request->password, $patient->password)) {
            throw ValidationException::withMessages([
                'login' => ['Email / Username atau Password salah'],
            ]);
        }

        // update last login
        $patient->update([
            'last_login_at' => now(),
        ]);

        // token Sanctum
        $token = $patient->createToken('patient-mobile')->plainTextToken;

        return response()->json([
            'token'   => $token,
            'user'    => [
                'id'           => $patient->id,
                'name'         => $patient->nama_lengkap,  // Flutter expect 'name'
                'email'        => $patient->email,
                'username'     => $patient->username,
            ]
        ])
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization');
    }

    /**
     * =====================
     * LOGOUT (MOBILE)
     * =====================
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ])
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization');
    }
}
