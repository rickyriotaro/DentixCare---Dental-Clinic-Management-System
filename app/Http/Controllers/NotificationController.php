<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Patient;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('patient')->latest()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        $patients = Patient::orderBy('nama_lengkap')->get();
        return view('notifications.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'jenis'      => 'required',
            'judul'      => 'required',
            'pesan'      => 'required',
        ]);

        Notification::create([
            'patient_id' => $request->patient_id,
            'no_hp'      => $request->no_hp,
            'jenis'      => $request->jenis,
            'judul'      => $request->judul,
            'pesan'      => $request->pesan,
        ]);

        return redirect()
            ->route('notifications.index')
            ->with('success','Pemberitahuan berhasil dikirim ke pasien.');
    }
}
