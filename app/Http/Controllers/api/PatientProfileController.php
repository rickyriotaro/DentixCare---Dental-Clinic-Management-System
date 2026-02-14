<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientProfileController extends Controller
{
    /**
     * Get patient profile
     */
    public function show(Request $request)
    {
        $patient = $request->user();
        
        return response()->json([
            'id' => $patient->id,
            'nama_lengkap' => $patient->nama_lengkap,
            'email' => $patient->email,
            'username' => $patient->username,
            'no_hp' => $patient->no_hp,
            'alamat' => $patient->alamat,
            'registered_at' => $patient->created_at
        ]);
    }

    /**
     * Update patient profile
     */
    public function update(Request $request)
    {
        $patient = $request->user();
        
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string'
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'no_hp.required' => 'Nomor HP wajib diisi'
        ]);
        
        $patient->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diperbarui',
            'user' => [
                'id' => $patient->id,
                'nama_lengkap' => $patient->nama_lengkap,
                'email' => $patient->email,
                'username' => $patient->username,
                'no_hp' => $patient->no_hp,
                'alamat' => $patient->alamat
            ]
        ]);
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ], [
            'old_password.required' => 'Password lama wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);
        
        $patient = $request->user();
        
        if (!Hash::check($request->old_password, $patient->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak sesuai'
            ], 422);
        }
        
        $patient->update([
            'password' => Hash::make($request->new_password)
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
}
