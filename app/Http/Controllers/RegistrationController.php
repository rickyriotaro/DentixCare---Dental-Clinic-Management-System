<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('pendaftaran.create');
    }

   public function store(Request $request)
{
    $data = $request->validate([
        'nama_lengkap' => ['required', 'string', 'max:255'],
        'alamat'       => ['nullable', 'string', 'max:255'],
        'no_hp'        => ['required', 'string', 'max:20'],   // biar lebih valid, No HP wajib
        'keluhan'      => ['nullable', 'string', 'max:255'],
    ]);

    // Auto-generate email & username untuk pasien walk-in (belum punya akun)
    $data['email'] = 'patient_' . time() . '@klinik.local';
    $data['username'] = 'patient_' . time();
    $data['password'] = bcrypt('password123'); // default password, bisa diganti nanti

    Patient::create($data);

    // berhasil -> tetap di halaman pendaftaran + pesan sukses
    return redirect()
        ->route('pendaftaran.create')
        ->with('success', 'Pendaftaran berhasil! Data sudah masuk ke Data Pasien.');
}

}
