<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'alamat'       => ['nullable', 'string'],
            'no_hp'        => ['required', 'string', 'max:20'],
            'email'        => ['required', 'email', 'unique:patients,email'],
            'username'     => ['required', 'string', 'unique:patients,username'],
            'password'     => ['required', 'min:6'],
            'keluhan'      => ['nullable', 'string'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan, gunakan username lain',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'no_hp.required' => 'Nomor HP wajib diisi',
        ]);

        $data['password'] = Hash::make($data['password']);

        Patient::create($data);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil ditambahkan');
    }

    public function show(Patient $patient)
    {
        // Load all related data with counts
        $patient->loadCount([
            'appointments',
            'medicalRecords',
            'treatmentPlans',
        ]);

        // Count controls through medical records
        $controlsCount = \DB::table('patient_controls')
            ->join('medical_records', 'patient_controls.medical_record_id', '=', 'medical_records.id')
            ->where('medical_records.patient_id', $patient->id)
            ->count();

        // Load latest appointments with doctor info
        $latestAppointments = $patient->appointments()
            ->with('dokter:id,name')
            ->latest()
            ->limit(5)
            ->get();

        // Load latest medical records with doctor info
        $latestMedicalRecords = $patient->medicalRecords()
            ->with('dokter:id,name')
            ->latest()
            ->limit(5)
            ->get();

        // Load latest treatment plans with doctor info
        $latestTreatmentPlans = $patient->treatmentPlans()
            ->with('dokter:id,name')
            ->latest()
            ->limit(5)
            ->get();

        // Load latest control schedules through medical records
        $latestControls = \App\Models\PatientControl::query()
            ->join('medical_records', 'patient_controls.medical_record_id', '=', 'medical_records.id')
            ->where('medical_records.patient_id', $patient->id)
            ->with('dokter:id,name')
            ->select('patient_controls.*')
            ->latest('patient_controls.created_at')
            ->limit(5)
            ->get();

        return view('patients.show', compact(
            'patient',
            'controlsCount',
            'latestAppointments',
            'latestMedicalRecords',
            'latestTreatmentPlans',
            'latestControls'
        ));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'alamat'       => ['nullable', 'string'],
            'no_hp'        => ['required', 'string', 'max:20'],
            'email'        => ['required', 'email', 'unique:patients,email,' . $patient->id],
            'username'     => ['required', 'string', 'unique:patients,username,' . $patient->id],
            'password'     => ['nullable', 'min:6'],
            'keluhan'      => ['nullable', 'string'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan, gunakan username lain',
            'password.min' => 'Password minimal 6 karakter',
            'no_hp.required' => 'Nomor HP wajib diisi',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $patient->update($data);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus');
    }
}
