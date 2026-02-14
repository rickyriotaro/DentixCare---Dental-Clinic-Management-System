<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\PatientControl;
use Illuminate\Http\Request;

class DokterPatientControlController extends Controller
{
    // (1) daftar pasien (ambil dari medical_records)
    public function index()
    {
        $records = MedicalRecord::with(['patient', 'dokter', 'controls' => function($q){
                $q->latest();
            }])
            ->orderByDesc('tanggal_masuk')
            ->paginate(10);

        return view('dokter.kontrol.index', compact('records'));
    }

    // (2) detail kontrol + perawatan terakhir pasien
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'dokter', 'controls.dokter']);

        // kontrol terbaru
        $lastControl = $medicalRecord->controls()->latest()->first();

        return view('dokter.kontrol.show', compact('medicalRecord','lastControl'));
    }

    // (3) form jadwalkan kontrol
    public function create(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load('patient');

        return view('dokter.kontrol.create', compact('medicalRecord'));
    }

    // (4) simpan jadwal kontrol
    public function store(Request $request, MedicalRecord $medicalRecord)
    {
        $data = $request->validate([
            'tanggal_kontrol' => ['required','date'],
            'jam_kontrol'     => ['nullable'],
            'catatan'         => ['nullable','string'],
        ]);

        $data['medical_record_id'] = $medicalRecord->id;
        $data['dokter_id'] = auth()->id(); //  taruh di sini (saat dokter menyimpan)
        $data['status'] = 'terjadwal';

        $control = PatientControl::create($data);

        // Kirim notifikasi ke pasien
        \App\Models\Notification::create([
            'patient_id' => $medicalRecord->patient_id,
            'jenis'      => 'jadwal_kontrol',
            'judul'      => 'Jadwal Kontrol Baru',
            'pesan'      => 'Dokter telah menjadwalkan kontrol untuk Anda pada tanggal ' . \Carbon\Carbon::parse($data['tanggal_kontrol'])->translatedFormat('d F Y') . ($data['jam_kontrol'] ? ' pukul ' . $data['jam_kontrol'] : ''),
            'status'     => 'unread',
            'related_id' => $control->id,
        ]);

        return redirect()
            ->route('dokter.kontrol.show', $medicalRecord->id)
            ->with('success', 'Kontrol berhasil dijadwalkan.');
    }
}
