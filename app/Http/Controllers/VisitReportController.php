<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\VisitReport;           // buat model ini (lihat step migration)
use App\Models\VisitReportItem;       // buat model ini (lihat step migration)

class VisitReportController extends Controller
{
    public function index(Request $request)
    {
        // halaman awal: tampilkan kosong atau default data terbaru
        $filters = $this->getFilters($request);

        $rows = MedicalRecord::query()
            ->with(['patient'])
            ->when($filters['from'], fn($q) => $q->whereDate('tanggal_masuk', '>=', $filters['from']))
            ->when($filters['to'], fn($q) => $q->whereDate('tanggal_masuk', '<=', $filters['to']))
            ->when($filters['nama'], fn($q) => $q->whereHas('patient', fn($subQ) => $subQ->where('nama_lengkap', 'like', "%{$filters['nama']}%")))
            ->orderByDesc('tanggal_masuk')
            ->paginate(10)
            ->appends($request->query());

        return view('reports.visits.index', ['records' => $rows,'filters' => $filters,]);
    }
    // tombol "Tampilkan hasil laporan" -> cukup panggil halaman yang sama dengan query filter
    public function filter(Request $request)
    {
        return redirect()->route('reports.visits.index', $request->query());
    }
    // tombol "Simpan Laporan"
    public function save(Request $request)
    {
        $filters = $this->getFilters($request);

        // Ambil data sesuai filter (tanpa paginate karena mau disimpan semua hasilnya)
        $rows = MedicalRecord::query()
            ->with(['patient'])
            ->when($filters['from'], fn($q) => $q->whereDate('tanggal_masuk', '>=', $filters['from']))
            ->when($filters['to'], fn($q) => $q->whereDate('tanggal_masuk', '<=', $filters['to']))
            ->when($filters['nama'], fn($q) => $q->whereHas('patient', fn($subQ) => $subQ->where('nama_lengkap', 'like', "%{$filters['nama']}%")))
            ->orderByDesc('tanggal_masuk')
            ->get();

        if ($rows->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk disimpan. Silakan filter dulu.');
        }

        // simpan header laporan
        $report = VisitReport::create([
            'user_id' => auth()->id(),
            'from_date' => $filters['from'],
            'to_date' => $filters['to'],
            'nama_pasien' => $filters['nama'],
            'keluhan' => null,
            'riwayat_penyakit' => null,
            'total' => $rows->count(),
        ]);

        // simpan detail snapshot hasil
        foreach ($rows as $r) {
            VisitReportItem::create([
                'visit_report_id' => $report->id,
                'medical_record_id' => $r->id,
                'no_rm' => $r->no_rm,
                'nama_pasien' => $r->patient?->nama_lengkap ?? '-',
                'alamat' => $r->patient?->alamat ?? '-',
                'tanggal_masuk' => $r->tanggal_masuk,
                'keluhan' => $r->keluhan,
                'alergi' => $r->alergi,
                'riwayat_penyakit' => $r->riwayat_penyakit,
                'rencana_perawatan' => $r->tindakan, // kalau rencana kamu simpan di kolom lain, ganti ini
            ]);
        }

        return redirect()
    ->route('reports.visits.index', $filters)
    ->with('success', 'Laporan berhasil disimpan.');
    }

    private function getFilters(Request $request): array
    {
        return [
            'from' => $request->query('from') ?? $request->input('from'),
            'to' => $request->query('to') ?? $request->input('to'),
            'nama' => $request->query('nama') ?? $request->input('nama'),
        ];
    }
}
