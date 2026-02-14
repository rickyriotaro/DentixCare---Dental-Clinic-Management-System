<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class DokterRiwayatPerawatanController extends Controller
{
    // daftar riwayat perawatan
    public function index(Request $request)
    {
        $q = $request->query('q');

        $records = MedicalRecord::with(['patient','dokter'])
            // riwayat = yang sudah pernah diisi dokter (diagnosa/tindakan/resep)
            ->where(function ($w) {
                $w->whereNotNull('diagnosa')
                  ->orWhereNotNull('tindakan')
                  ->orWhereNotNull('resep_obat');
            })
            ->when($q, function ($w) use ($q) {
                $w->where('nama_pasien', 'like', "%{$q}%")
                  ->orWhere('no_rm', 'like', "%{$q}%")
                  ->orWhereHas('patient', function ($p) use ($q) {
                      $p->where('nama_pasien', 'like', "%{$q}%")
                        ->orWhere('no_hp', 'like', "%{$q}%");
                  });
            })
            ->orderByDesc('tanggal_masuk')
            ->paginate(10)
            ->withQueryString();

        return view('dokter.riwayat.index', compact('records','q'));
    }

    // detail riwayat (detail rekam medis)
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient','dokter']);

        // optional: kalau mau batasi hanya yang sudah ada riwayat
        // if (blank($medicalRecord->diagnosa) && blank($medicalRecord->tindakan) && blank($medicalRecord->resep_obat)) abort(404);

        return view('dokter.riwayat.show', compact('medicalRecord'));
    }
}
