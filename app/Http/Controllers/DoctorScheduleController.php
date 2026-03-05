<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\Notification;
use App\Models\Patient;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        $schedules = DoctorSchedule::orderBy('tanggal', 'desc')->paginate(15);
        return view('jadwal-libur.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'    => 'required|date|unique:doctor_schedules,tanggal',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.unique'   => 'Tanggal ini sudah terdaftar sebagai hari libur.',
        ]);

        $schedule = DoctorSchedule::create([
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        // Broadcast notifikasi ke semua pasien
        $tanggalFormatted = \Carbon\Carbon::parse($schedule->tanggal)->format('d-m-Y');
        $pesan = 'Klinik tidak buka pada tanggal ' . $tanggalFormatted . '.';
        if ($schedule->keterangan) {
            $pesan .= ' Keterangan: ' . $schedule->keterangan;
        }

        $patients = Patient::all();
        foreach ($patients as $patient) {
            Notification::create([
                'patient_id' => $patient->id,
                'no_hp'      => $patient->no_hp ?? '',
                'jenis'      => 'jadwal',
                'judul'      => '📅 Pemberitahuan Jadwal Klinik',
                'pesan'      => $pesan,
                'status'     => 'unread',
            ]);
        }

        return redirect()->route('jadwal-libur.index')
            ->with('success', 'Jadwal libur berhasil ditambahkan dan notifikasi terkirim ke ' . $patients->count() . ' pasien.');
    }

    public function destroy($id)
    {
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('jadwal-libur.index')
            ->with('success', 'Jadwal libur berhasil dihapus.');
    }
}
