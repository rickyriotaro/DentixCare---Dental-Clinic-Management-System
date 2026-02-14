<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class PatientMedicalRecordController extends Controller
{
    /**
     * List all medical records for authenticated patient
     */
    public function index(Request $request)
    {
        $records = MedicalRecord::with(['patient', 'dokter'])
            ->where('patient_id', $request->user()->id)
            ->latest('tanggal_masuk')
            ->get();
        
        return response()->json([
            'medical_records' => $records
        ]);
    }

    /**
     * Get medical record detail
     */
    public function show(Request $request, $id)
    {
        $record = MedicalRecord::with(['patient', 'dokter'])
            ->where('patient_id', $request->user()->id)
            ->findOrFail($id);
        
        return response()->json($record);
    }
}
