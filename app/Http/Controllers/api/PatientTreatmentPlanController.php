<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TreatmentPlan;
use Illuminate\Http\Request;

class PatientTreatmentPlanController extends Controller
{
    /**
     * List all treatment plans for authenticated patient
     */
    public function index(Request $request)
    {
        $treatmentPlans = TreatmentPlan::with(['medicalRecord', 'dokter'])
            ->where('patient_id', $request->user()->id)
            ->latest('tanggal_rencana')
            ->get();
        
        return response()->json([
            'treatment_plans' => $treatmentPlans
        ]);
    }

    /**
     * Get treatment plan detail
     */
    public function show(Request $request, $id)
    {
        $treatmentPlan = TreatmentPlan::with(['medicalRecord', 'dokter', 'patient'])
            ->where('patient_id', $request->user()->id)
            ->findOrFail($id);
        
        return response()->json($treatmentPlan);
    }
}
