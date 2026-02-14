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
}
