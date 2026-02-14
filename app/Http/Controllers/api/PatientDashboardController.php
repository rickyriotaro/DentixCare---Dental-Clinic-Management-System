<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PatientControl;
use App\Models\TreatmentPlan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PatientDashboardController extends Controller
{
    /**
     * Get upcoming schedules (appointments, controls, treatment plans)
     * Combined and sorted by date, limit to 2 most recent
     */
    public function upcomingSchedules(Request $request)
    {
        $patientId = $request->user()->id;
        $schedules = [];

        // 1. Appointments (approved only, future dates)
        $appointments = Appointment::where('patient_id', $patientId)
            ->where('status', 'approved')
            ->where('tanggal_dikonfirmasi', '>=', Carbon::today())
            ->get()
            ->map(function($apt) {
                return [
                    'id' => $apt->id,
                    'type' => 'appointment',
                    'title' => 'Janji Temu',
                    'date' => $apt->tanggal_dikonfirmasi,
                    'time' => $apt->jam_dikonfirmasi,
                    'description' => $apt->keluhan ?? '-',
                    'status' => 'approved',
                    'icon' => 'calendar_today',
                    'color' => 'blue',
                ];
            });

        // 2. Controls (terjadwal only, future dates)
        // Note: patient_controls doesn't have patient_id, need to join via medical_records
        $controls = PatientControl::with('dokter')
            ->join('medical_records', 'patient_controls.medical_record_id', '=', 'medical_records.id')
            ->where('medical_records.patient_id', $patientId)
            ->where('patient_controls.status', 'terjadwal')
            ->whereNotNull('patient_controls.tanggal_kontrol')
            ->where('patient_controls.tanggal_kontrol', '>=', Carbon::today())
            ->select('patient_controls.*')
            ->get()
            ->map(function($ctrl) {
                return [
                    'id' => $ctrl->id,
                    'type' => 'jadwal_kontrol',
                    'title' => 'Jadwal Kontrol',
                    'date' => $ctrl->tanggal_kontrol,
                    'time' => $ctrl->jam_kontrol,
                    'description' => $ctrl->catatan ?? 'Kontrol rutin',
                    'doctor' => $ctrl->dokter?->name ?? 'Dokter',
                    'status' => 'terjadwal',
                    'icon' => 'event_note',
                    'color' => 'purple',
                ];
            });

        // 3. Treatment Plans (draft only, future dates)
        $plans = TreatmentPlan::with('dokter')
            ->where('patient_id', $patientId)
            ->where('status', 'draft')
            ->whereNotNull('tanggal_rencana')
            ->where('tanggal_rencana', '>=', Carbon::today())
            ->get()
            ->map(function($plan) {
                return [
                    'id' => $plan->id,
                    'type' => 'rencana_perawatan',
                    'title' => $plan->judul ?? 'Rencana Perawatan',
                    'date' => $plan->tanggal_rencana,
                    'time' => $plan->jam_rencana,
                    'description' => $plan->rencana ?? '-',
                    'doctor' => $plan->dokter?->name ?? 'Dokter',
                    'status' => 'draft',
                    'icon' => 'medical_services',
                    'color' => 'green',
                ];
            });

        // Combine all
        $schedules = $appointments->concat($controls)->concat($plans);

        // Sort by date (earliest first), then limit to 2
        $sorted = $schedules->sortBy(function($item) {
            return $item['date'];
        })->take(2)->values();

        return response()->json([
            'schedules' => $sorted
        ]);
    }
}
