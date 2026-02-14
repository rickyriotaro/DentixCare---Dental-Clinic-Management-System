<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Http\Request;

class DokterAppointmentController extends Controller
{
    public function index()
    {
        // Dokter bisa lihat SEMUA appointments (pending, approved, rejected)
        $appointments = Appointment::with('patient')
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->orderBy('tanggal_diminta')
            ->orderBy('jam_diminta')
            ->paginate(10);

        return view('dokter.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load('patient');
        return view('dokter.appointments.show', compact('appointment'));
    }

    public function approve(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'tanggal_dikonfirmasi' => ['required', 'date'],
            'jam_dikonfirmasi'     => ['required'],
        ]);

        // Cek tabrakan jadwal
        $exists = Appointment::where('status', 'approved')
            ->where('tanggal_dikonfirmasi', $data['tanggal_dikonfirmasi'])
            ->where('jam_dikonfirmasi', $data['jam_dikonfirmasi'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['jam_dikonfirmasi' => 'Jadwal ini sudah terisi, pilih jam lain.'])->withInput();
        }

        $appointment->update([
            'tanggal_dikonfirmasi' => $data['tanggal_dikonfirmasi'],
            'jam_dikonfirmasi'     => $data['jam_dikonfirmasi'],
            'status'               => 'approved',
        ]);

        // Kirim notifikasi ke pasien
        Notification::create([
            'patient_id' => $appointment->patient_id,
            'no_hp'      => $appointment->patient->no_hp ?? '',
            'jenis'      => 'appointment',
            'judul'      => 'Jadwal Janji Temu Disetujui',
            'pesan'      => 'Janji temu Anda disetujui pada ' .
                $appointment->tanggal_dikonfirmasi . ' pukul ' . $appointment->jam_dikonfirmasi . '.',
            'status'     => 'unread',
        ]);

        return redirect()->route('dokter.appointments.index')->with('success', 'Jadwal berhasil disetujui dan notifikasi terkirim.');
    }

    public function reject(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'rejected'
        ]);

        Notification::create([
            'patient_id' => $appointment->patient_id,
            'no_hp'      => $appointment->patient->no_hp ?? '',
            'jenis'      => 'appointment',
            'judul'      => 'Jadwal Janji Temu Ditolak',
            'pesan'      => 'Maaf, permintaan janji temu Anda belum dapat diproses. Silakan ajukan jadwal lain.',
            'status'     => 'unread',
        ]);

        return redirect()->route('dokter.appointments.index')->with('success', 'Permintaan ditolak dan notifikasi terkirim.');
    }
}
