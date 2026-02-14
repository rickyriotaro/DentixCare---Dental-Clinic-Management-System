<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class DokterMedicalRecordController extends Controller
{
    // daftar pasien yg bisa diisi dokter
    public function index()
    {
        $records = MedicalRecord::with('patient')
            ->orderByDesc('tanggal_masuk')
            ->paginate(10);

        return view('dokter.rekammedis.index', compact('records'));
    }

    // detail RM
    public function show(MedicalRecord $medicalRecord)
    {
        return view('dokter.rekammedis.show', compact('medicalRecord'));
    }
    /// form input diagnosa
    public function input(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient','dokter']);
        return view('dokter.rekammedis.input', compact('medicalRecord'));
    }

    // SIMPAN → dokter_id DI SINI 🔥
    public function saveInput(Request $request, MedicalRecord $medicalRecord)
    {
        $data = $request->validate([
            'diagnosa'   => 'required|string',
            'tindakan'   => 'required|string',
            'resep_obat' => 'required|string',
            'catatan'    => 'nullable|string',
        ]);

        $medicalRecord->update([
            ...$data,
            'dokter_id' => auth()->id(), //  PENTING
        ]);

        return redirect()
            ->route('dokter.rekammedis.show', $medicalRecord->id)
            ->with('success','Rekam medis berhasil diisi.');
    }
}

