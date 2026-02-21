<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{
    /**
     * List all patient appointments
     */
    public function index(Request $request)
    {
        $query = Appointment::with('dokter')->where('patient_id', $request->user()->id);
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $appointments = $query->latest()->get();
        
        return response()->json([
            'appointments' => $appointments
        ]);
    }

    /**
     * Create new appointment
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal_diminta' => 'required|date|after_or_equal:today',
            'jam_diminta' => 'required',
            'keluhan' => 'required|string'
        ], [
            'tanggal_diminta.required' => 'Tanggal wajib diisi',
            'tanggal_diminta.after_or_equal' => 'Tanggal tidak boleh kurang dari hari ini',
            'jam_diminta.required' => 'Jam wajib diisi',
            'keluhan.required' => 'Keluhan wajib diisi'
        ]);
        
        $data['patient_id'] = $request->user()->id;
        $data['status'] = 'pending';
        
        $appointment = Appointment::create($data);
        
        // Update patient's keluhan field
        Patient::where('id', $request->user()->id)
            ->update(['keluhan' => $data['keluhan']]);
        
        return response()->json([
            'success' => true,
            'message' => 'Janji temu berhasil dibuat. Menunggu konfirmasi admin.',
            'appointment' => $appointment
        ], 201);
    }

    /**
     * Get appointment detail
     */
    public function show(Request $request, $id)
    {
        $appointment = Appointment::with('dokter')
            ->where('patient_id', $request->user()->id)
            ->findOrFail($id);
        
        return response()->json($appointment);
    }

    /**
     * Cancel appointment (soft delete)
     */
    public function destroy(Request $request, $id)
    {
        $appointment = Appointment::where('patient_id', $request->user()->id)
            ->where('status', 'pending')
            ->findOrFail($id);
        
        $appointment->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Janji temu berhasil dibatalkan'
        ]);
    }

    /**
     * Get upcoming appointments for dashboard
     */
    public function upcoming(Request $request)
    {
        $appointments = Appointment::where('patient_id', $request->user()->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where('tanggal_diminta', '>=', now()->toDateString())
            ->orderBy('tanggal_diminta')
            ->orderBy('jam_diminta')
            ->limit(3)
            ->get();
        
        return response()->json([
            'appointments' => $appointments
        ]);
    }

    /**
     * GET /patient/appointments/slots?date=YYYY-MM-DD
     * Return booked slots for a given date (so mobile can disable them)
     */
    public function getAvailableSlots(Request $request)
    {
        $date = $request->query('date');
        if (!$date) {
            return response()->json(['error' => 'date parameter required'], 400);
        }

        // All possible slots
        $allSlots = ['16:00', '17:00', '18:00', '19:00', '20:00'];

        // Slots already booked — pakai jam_dikonfirmasi (jam yg DOKTER set), bukan jam_diminta pasien
        // Hanya approved yang blok, karena itulah jam yg benar-benar dikonfirmasi
        $bookedSlots = Appointment::whereDate('tanggal_dikonfirmasi', $date)
            ->where('status', 'approved')
            ->whereNotNull('jam_dikonfirmasi')
            ->pluck('jam_dikonfirmasi')
            ->map(fn($t) => substr($t, 0, 5)) // normalise "16:00:00" → "16:00"
            ->toArray();

        // If date is today (WIB), also mark past/current slots as unavailable
        $pastSlots = [];
        $nowWib = now(); // 'Asia/Jakarta' from config
        if ($date === $nowWib->toDateString()) {
            foreach ($allSlots as $slot) {
                // Parse slot as a Carbon time on today's date
                [$slotHour, $slotMin] = explode(':', $slot);
                $slotTime = $nowWib->copy()->setTime((int)$slotHour, (int)$slotMin, 0);
                // Disable if slot time has already passed (give 5-min buffer)
                if ($nowWib->gte($slotTime)) {
                    $pastSlots[] = $slot;
                }
            }
        }

        $unavailable = array_values(array_unique(array_merge($bookedSlots, $pastSlots)));

        return response()->json([
            'date'        => $date,
            'all_slots'   => $allSlots,
            'unavailable' => $unavailable,
        ]);
    }
}
