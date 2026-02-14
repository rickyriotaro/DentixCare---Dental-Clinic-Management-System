<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientControl;
use Illuminate\Http\Request;

class PatientControlController extends Controller
{
    /**
     * List all patient controls (via medical records)
     */
    public function index(Request $request)
    {
        // Get controls from medical records that belong to this patient
        $controls = PatientControl::with(['medicalRecord', 'dokter'])
            ->whereHas('medicalRecord', function($query) use ($request) {
                $query->where('patient_id', $request->user()->id);
            })
            ->latest('tanggal_kontrol')
            ->get();
        
        return response()->json([
            'controls' => $controls
        ]);
    }

    /**
     * Get patient control detail
     */
    public function show(Request $request, $id)
    {
        $control = PatientControl::with(['medicalRecord', 'dokter'])
            ->whereHas('medicalRecord', function($query) use ($request) {
                $query->where('patient_id', $request->user()->id);
            })
            ->findOrFail($id);
        
        return response()->json($control);
    }
}
