<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterManagementController extends Controller
{
    public function index()
    {
        $dokters = User::where('role', 'dokter')->latest()->paginate(10);
        return view('dokters.index', compact('dokters'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
        ], [
            'name.required' => 'Nama dokter wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'dokter';

        User::create($data);

        return redirect()
            ->route('dokters.index')
            ->with('success', 'Data dokter berhasil ditambahkan');
    }

    public function update(Request $request, User $dokter)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $dokter->id],
            'password' => ['nullable', 'min:6'],
        ], [
            'name.required' => 'Nama dokter wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $dokter->update($data);

        return redirect()
            ->route('dokters.index')
            ->with('success', 'Data dokter berhasil diperbarui');
    }

    public function destroy(User $dokter)
    {
        $dokter->delete();

        return redirect()
            ->route('dokters.index')
            ->with('success', 'Data dokter berhasil dihapus');
    }
}
