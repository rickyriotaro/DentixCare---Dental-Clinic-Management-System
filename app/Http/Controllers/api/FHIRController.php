<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Http\Resources\FHIR\PatientResource;
use App\Http\Resources\FHIR\AppointmentResource;
use App\Http\Resources\FHIR\ConditionResource;
use App\Http\Resources\FHIR\ProcedureResource;
use Illuminate\Http\Request;

class FHIRController extends Controller
{
    /**
     * =====================================
     * FHIR PATIENT RESOURCE
     * =====================================
     */
    
    /**
     * GET /fhir/Patient/{id}
     * Get single patient in FHIR format
     */
    public function getPatient($id)
    {
        $patient = Patient::findOrFail($id);
        return new PatientResource($patient);
    }

    /**
     * GET /fhir/Patient
     * Get all patients in FHIR Bundle format
     */
    public function getAllPatients(Request $request)
    {
        $perPage = $request->get('_count', 20);
        $patients = Patient::paginate($perPage);
        
        return response()->json([
            'resourceType' => 'Bundle',
            'type' => 'searchset',
            'total' => $patients->total(),
            'entry' => PatientResource::collection($patients)->map(function($resource) {
                return [
                    'resource' => $resource,
                ];
            }),
            'link' => [
                [
                    'relation' => 'self',
                    'url' => $request->url()
                ],
                $patients->nextPageUrl() ? [
                    'relation' => 'next',
                    'url' => $patients->nextPageUrl()
                ] : null,
                $patients->previousPageUrl() ? [
                    'relation' => 'previous',
                    'url' => $patients->previousPageUrl()
                ] : null,
            ]
        ]);
    }

    /**
     * =====================================
     * FHIR APPOINTMENT RESOURCE
     * =====================================
     */
    
    /**
     * GET /fhir/Appointment/{id}
     * Get single appointment in FHIR format
     */
    public function getAppointment($id)
    {
        $appointment = Appointment::with(['patient', 'dokter'])->findOrFail($id);
        return new AppointmentResource($appointment);
    }

    /**
     * GET /fhir/Appointment
     * Get appointments in FHIR Bundle format
     */
    public function getAllAppointments(Request $request)
    {
        $query = Appointment::with(['patient', 'dokter']);
        
        // Filter by patient if provided
        if ($request->has('patient')) {
            $query->where('patient_id', $request->get('patient'));
        }
        
        $perPage = $request->get('_count', 20);
        $appointments = $query->paginate($perPage);
        
        return response()->json([
            'resourceType' => 'Bundle',
            'type' => 'searchset',
            'total' => $appointments->total(),
            'entry' => AppointmentResource::collection($appointments)->map(function($resource) {
                return [
                    'resource' => $resource,
                ];
            }),
        ]);
    }

    /**
     * =====================================
     * FHIR CONDITION RESOURCE (Diagnosis)
     * =====================================
     */
    
    /**
     * GET /fhir/Condition/{id}
     * Get medical record diagnosis in FHIR Condition format
     */
    public function getCondition($id)
    {
        $record = MedicalRecord::with(['patient', 'dokter'])->findOrFail($id);
        return new ConditionResource($record);
    }

    /**
     * GET /fhir/Condition
     * Get all conditions in FHIR Bundle format
     */
    public function getAllConditions(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'dokter']);
        
        // Filter by patient if provided
        if ($request->has('patient')) {
            $query->where('patient_id', $request->get('patient'));
        }
        
        $perPage = $request->get('_count', 20);
        $records = $query->paginate($perPage);
        
        return response()->json([
            'resourceType' => 'Bundle',
            'type' => 'searchset',
            'total' => $records->total(),
            'entry' => ConditionResource::collection($records)->map(function($resource) {
                return [
                    'resource' => $resource,
                ];
            }),
        ]);
    }

    /**
     * =====================================
     * FHIR PROCEDURE RESOURCE (Tindakan)
     * =====================================
     */
    
    /**
     * GET /fhir/Procedure/{id}
     * Get medical record procedure in FHIR format
     */
    public function getProcedure($id)
    {
        $record = MedicalRecord::with(['patient', 'dokter'])->findOrFail($id);
        return new ProcedureResource($record);
    }

    /**
     * GET /fhir/Procedure
     * Get all procedures in FHIR Bundle format
     */
    public function getAllProcedures(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'dokter']);
        
        // Filter by patient if provided
        if ($request->has('patient')) {
            $query->where('patient_id', $request->get('patient'));
        }
        
        $perPage = $request->get('_count', 20);
        $records = $query->paginate($perPage);
        
        return response()->json([
            'resourceType' => 'Bundle',
            'type' => 'searchset',
            'total' => $records->total(),
            'entry' => ProcedureResource::collection($records)->map(function($resource) {
                return [
                    'resource' => $resource,
                ];
            }),
        ]);
    }

    /**
     * =====================================
     * FHIR CAPABILITY STATEMENT
     * =====================================
     */
    
    /**
     * GET /fhir/metadata
     * Get server capability statement (what this FHIR server can do)
     */
    public function getCapabilityStatement()
    {
        return response()->json([
            'resourceType' => 'CapabilityStatement',
            'status' => 'active',
            'date' => now()->toIso8601String(),
            'kind' => 'instance',
            'software' => [
                'name' => 'Dentix FHIR Server',
                'version' => '1.0.0',
            ],
            'implementation' => [
                'description' => 'Dentix Dental Clinic FHIR API',
                'url' => url('/api/fhir')
            ],
            'fhirVersion' => '4.0.1',
            'format' => ['json'],
            'rest' => [
                [
                    'mode' => 'server',
                    'resource' => [
                        [
                            'type' => 'Patient',
                            'interaction' => [
                                ['code' => 'read'],
                                ['code' => 'search-type'],
                            ],
                            'searchParam' => [
                                ['name' => '_count', 'type' => 'number'],
                            ],
                            'operation' => [
                                [
                                    'name' => 'everything',
                                    'definition' => url('/api/fhir/Patient/$everything')
                                ]
                            ]
                        ],
                        [
                            'type' => 'Appointment',
                            'interaction' => [
                                ['code' => 'read'],
                                ['code' => 'search-type'],
                            ],
                            'searchParam' => [
                                ['name' => 'patient', 'type' => 'reference'],
                                ['name' => '_count', 'type' => 'number'],
                            ]
                        ],
                        [
                            'type' => 'Condition',
                            'interaction' => [
                                ['code' => 'read'],
                                ['code' => 'search-type'],
                            ],
                            'searchParam' => [
                                ['name' => 'patient', 'type' => 'reference'],
                                ['name' => '_count', 'type' => 'number'],
                            ]
                        ],
                        [
                            'type' => 'Procedure',
                            'interaction' => [
                                ['code' => 'read'],
                                ['code' => 'search-type'],
                            ],
                            'searchParam' => [
                                ['name' => 'patient', 'type' => 'reference'],
                                ['name' => '_count', 'type' => 'number'],
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * =====================================
     * FHIR PATIENT EVERYTHING
     * =====================================
     */
    
    /**
     * GET /fhir/Patient/{id}/$everything
     * Get all data for a patient in FHIR Bundle format
     */
    public function getPatientEverything($id)
    {
        $patient = Patient::with([
            'appointments.dokter',
            'medicalRecords.dokter'
        ])->findOrFail($id);

        $entries = [];

        // Add patient resource
        $entries[] = [
            'resource' => new PatientResource($patient)
        ];

        // Add appointments
        foreach ($patient->appointments as $appointment) {
            $entries[] = [
                'resource' => new AppointmentResource($appointment)
            ];
        }

        // Add medical records (as both Condition and Procedure)
        foreach ($patient->medicalRecords as $record) {
            $entries[] = [
                'resource' => new ConditionResource($record)
            ];
            $entries[] = [
                'resource' => new ProcedureResource($record)
            ];
        }

        return response()->json([
            'resourceType' => 'Bundle',
            'type' => 'collection',
            'total' => count($entries),
            'entry' => $entries,
            'meta' => [
                'lastUpdated' => now()->toIso8601String()
            ]
        ]);
    }
}
