<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\TreatmentPlan;
use App\Models\PatientControl;
use Illuminate\Http\Request;

class DokterTreatmentPlanController extends Controller
{
    // (1) daftar rekam medis pasien (sebagai pintu masuk buat rencana)
    public function index()
    {
        $records = MedicalRecord::with('patient')
            ->orderByDesc('tanggal_masuk')
            ->paginate(10);

        return view('dokter.perawatan.index', compact('records'));
    }

    // (2) detail rekam medis + daftar rencana perawatan
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load('patient', 'dokter');

        $plans = TreatmentPlan::with('dokter')
            ->where('medical_record_id', $medicalRecord->id)
            ->orderByDesc('created_at')
            ->get();

        return view('dokter.perawatan.show', compact('medicalRecord', 'plans'));
    }

    // (3) tampilkan form buat rencana
    public function create(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load('patient');
        return view('dokter.perawatan.create', compact('medicalRecord'));
    }

    // (4) simpan rencana perawatan
    public function store(Request $request, MedicalRecord $medicalRecord)
    {
        $data = $request->validate([
            'tanggal_rencana' => ['nullable', 'date'],
            'jam_rencana'     => ['nullable', 'string'],
            'judul'           => ['nullable', 'string', 'max:150'],
            'rencana'         => ['required', 'string'],
            'catatan'         => ['nullable', 'string'],
            'status'          => ['required', 'in:draft,selesai'],
        ]);

        $plan = TreatmentPlan::create([
            'medical_record_id' => $medicalRecord->id,
            'patient_id'        => $medicalRecord->patient_id,
            'dokter_id'         => auth()->id(),
            ...$data,
        ]);

        // ✅ Auto-create / update PatientControl from rencana perawatan
        PatientControl::updateOrCreate(
            ['medical_record_id' => $medicalRecord->id],
            [
                'dokter_id'       => auth()->id(),
                // Gunakan tanggal rencana, atau hari ini sebagai fallback (kolom NOT NULL)
                'tanggal_kontrol' => $data['tanggal_rencana'] ?? now()->toDateString(),
                'jam_kontrol'     => $data['jam_rencana'] ?? null,
                // 'terjadwal' sesuai DB: terjadwal | selesai | batal
                'status'          => 'terjadwal',
                'catatan'         => $data['judul'] ?? 'Rencana perawatan dari dokter',
            ]
        );

        // Kirim notifikasi ke pasien
        \App\Models\Notification::create([
            'patient_id' => $medicalRecord->patient_id,
            'jenis'      => 'rencana_perawatan',
            'judul'      => 'Rencana Perawatan Baru',
            'pesan'      => 'Dokter telah membuat rencana perawatan untuk Anda: ' . ($data['judul'] ?? 'Rencana Perawatan'),
            'status'     => 'unread',
            'related_id' => $plan->id,
        ]);

        return redirect()
            ->route('dokter.perawatan.show', $medicalRecord->id)
            ->with('success', 'Rencana perawatan berhasil disimpan.');
    }

    // (5) Tandai rencana selesai
    public function complete(TreatmentPlan $plan)
    {
        // Update status to selesai
        $plan->update(['status' => 'selesai']);

        // Send notification to patient
        \App\Models\Notification::create([
            'patient_id' => $plan->patient_id,
            'jenis'      => 'rencana_perawatan',
            'judul'      => 'Rencana Perawatan Selesai',
           'pesan'      => 'Rencana perawatan "' . ($plan->judul ?? 'Rencana Perawatan') . '" telah selesai dilaksanakan.',
            'status'     => 'unread',
            'related_id' => $plan->id,
        ]);

        return redirect()
            ->route('dokter.perawatan.show', $plan->medical_record_id)
            ->with('success', 'Rencana perawatan berhasil ditandai selesai dan notifikasi terkirim ke pasien.');
    }
}
