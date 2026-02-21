<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // (1) Sistem menampilkan daftar permintaan janji temu dari pasien
    public function index(Request $request)
    {
        $appointments = Appointment::with('patient')
            ->orderBy('tanggal_diminta')
            ->orderBy('jam_diminta')
            ->paginate(10)            // ✅ jadi paginator
            ->withQueryString();      // ✅ kalau ada filter nanti tidak hilang

        return view('appointments.index', compact('appointments'));
    }

    // (2) Admin melihat detail + ketersediaan jadwal (tampilan form konfirmasi)
    public function show(Appointment $appointment)
    {
        $appointment->load('patient');
        return view('appointments.show', compact('appointment'));
    }

    // (3) Admin mengatur/menyetujui jadwal -> sistem simpan konfirmasi + kirim pemberitahuan
    public function approve(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'tanggal_dikonfirmasi' => ['required', 'date'],
            'jam_dikonfirmasi'     => ['required'],
        ]);

        // Cek tabrakan jadwal (optional tapi bagus)
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

        // (4) Sistem mengirim pemberitahuan ke pasien
        Notification::create([
            'patient_id' => $appointment->patient_id,
            'no_hp'      => $appointment->patient->no_hp ?? '',
            'jenis'      => 'appointment',
            'judul'      => 'Jadwal Janji Temu Disetujui',
            'pesan'      => 'Janji temu Anda disetujui pada ' .
                $appointment->tanggal_dikonfirmasi . ' pukul ' . $appointment->jam_dikonfirmasi . '.',
            'status'     => 'unread',
            'related_id' => $appointment->id,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Jadwal berhasil disetujui dan notifikasi terkirim.');
    }

    public function reject(Request $request, Appointment $appointment)
    {
        $request->validate([
            'alasan' => 'nullable|string|max:500',
        ]);

        $appointment->update([
            'status'            => 'rejected',
            'alasan_penolakan'  => $request->input('alasan'),
        ]);

        $alasan = $request->input('alasan');
        $pesan = 'Maaf, permintaan janji temu Anda pada tanggal ' .
            $appointment->tanggal_diminta . ' pukul ' . $appointment->jam_diminta . ' belum dapat diproses.';
        if ($alasan) {
            $pesan .= ' Informasi dari klinik: ' . $alasan;
        } else {
            $pesan .= ' Silakan ajukan jadwal lain.';
        }

        Notification::create([
            'patient_id' => $appointment->patient_id,
            'no_hp'      => $appointment->patient->no_hp ?? '',
            'jenis'      => 'appointment',
            'judul'      => 'Jadwal Janji Temu Tidak Dapat Diproses',
            'pesan'      => $pesan,
            'status'     => 'unread',
            'related_id' => $appointment->id,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Permintaan ditolak dan notifikasi terkirim ke pasien.');
    }
}
