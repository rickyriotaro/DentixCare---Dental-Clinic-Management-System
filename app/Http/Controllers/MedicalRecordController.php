<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    // (1) menampilkan daftar data rekam medis pasien
    public function index()
    {
        $records = MedicalRecord::with('patient')->latest()->paginate(10);
        return view('rekam_medis.index', compact('records'));
    }

    // tombol “Tambah Data” (buat RM baru)
    public function create()
    {
        $patients = Patient::orderBy('nama_lengkap')->get();
        return view('rekam_medis.create', compact('patients'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'patient_id'       => ['required','integer','exists:patients,id'],
        'tanggal_masuk'    => ['required','date'],
        'keluhan'          => ['nullable','string','max:255'],
        'alergi'           => ['nullable','string','max:255'],
        'riwayat_penyakit' => ['nullable','string','max:255'],
        'dokter_id'        => ['nullable','integer','exists:users,id'],
    ]);

    // Auto-generate unique 5-digit no_rm
    do {
        $no_rm = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
    } while (MedicalRecord::where('no_rm', $no_rm)->exists());
    
    $data['no_rm'] = $no_rm;

    MedicalRecord::create($data);

    return redirect()
        ->route('rekammedis.index')
        ->with('success', 'Rekam medis berhasil disimpan dengan No.RM: ' . $no_rm);
}

    // (2) menampilkan halaman detail data rekam medis pasien
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load('patient');
        return view('rekam_medis.show', compact('medicalRecord'));
    }

    // (3) menampilkan form input rekam medis (diagnosa, tindakan, resep, catatan)
    public function input(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load('patient');
        return view('rekam_medis.input', compact('medicalRecord'));
    }

    // (4) simpan input rekam medis -> notif -> kembali ke detail
    public function saveInput(Request $request, MedicalRecord $medicalRecord)
    {
        $data = $request->validate([
            'diagnosa'   => ['required','string'],
            'tindakan'   => ['required','string'],
            'resep_obat' => ['required','string'],
            'catatan'    => ['nullable','string'],
        ]);

        $medicalRecord->update($data);

        return redirect()->route('rekammedis.show', $medicalRecord->id)
            ->with('success', 'Rekam medis berhasil disimpan.');
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $patients = Patient::orderBy('nama_lengkap')->get();
        return view('rekam_medis.edit', compact('medicalRecord','patients'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $data = $request->validate([
            'patient_id'       => ['required','integer'],
            'tanggal_masuk'    => ['required','date'],
            'keluhan'          => ['nullable','string','max:255'],
            'alergi'           => ['nullable','string','max:255'],
            'riwayat_penyakit' => ['nullable','string','max:255'],
        ]);

        $medicalRecord->update($data);

        return redirect()->route('rekammedis.index')->with('success','Data berhasil diupdate.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();
        return redirect()->route('rekammedis.index')->with('success','Data berhasil dihapus.');
    }

    // API: Get latest medical record data for patient (for auto-fill)
    public function getLatestData($patientId)
    {
        $latest = MedicalRecord::where('patient_id', $patientId)
            ->where(function($q) {
                $q->whereNotNull('alergi')
                  ->orWhereNotNull('riwayat_penyakit');
            })
            ->orderByDesc('tanggal_masuk')
            ->first();

        if (!$latest) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada rekam medis sebelumnya'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'alergi' => $latest->alergi ?? '',
                'riwayat_penyakit' => $latest->riwayat_penyakit ?? '',
            ]
        ]);
    }
}
