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
     * POST /fhir/Patient
     * Create new patient in FHIR format
     */
    public function createPatient(Request $request)
    {
        try {
            $fhirData = $request->all();
            
            // Validate FHIR resource type
            if (!isset($fhirData['resourceType']) || $fhirData['resourceType'] !== 'Patient') {
                return $this->createOperationOutcome('error', 'invalid', 'Invalid resourceType. Expected: Patient');
            }
            
            // Extract data from FHIR format
            $name = $fhirData['name'][0] ?? null;
            $telecom = $fhirData['telecom'] ?? [];
            $address = $fhirData['address'][0] ?? null;
            
            // Validate required fields
            if (!$name || !isset($name['family']) || !isset($name['given'][0])) {
                return $this->createOperationOutcome('error', 'required', 'Missing required field: name (family and given)');
            }
            
            // Find phone number
            $phone = null;
            foreach ($telecom as $contact) {
                if ($contact['system'] === 'phone') {
                    $phone = $contact['value'];
                    break;
                }
            }
            
            if (!$phone) {
                return $this->createOperationOutcome('error', 'required', 'Missing required field: telecom (phone)');
            }
            
            // Generate username from phone number
            $username = 'user_' . $phone;
            
            // Create patient
            $patient = Patient::create([
                'nama_lengkap' => $name['given'][0] . ' ' . $name['family'],
                'username' => $username,
                'email' => $this->extractEmail($telecom),
                'no_hp' => $phone,
                'alamat' => $address['text'] ?? null,
                'password' => bcrypt('password'), // Default password
            ]);
            
            return response()->json(new PatientResource($patient), 201)
                ->header('Location', url("/api/fhir/Patient/{$patient->id}"));
                
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * PUT /fhir/Patient/{id}
     * Update existing patient in FHIR format
     */
    public function updatePatient(Request $request, $id)
    {
        try {
            $patient = Patient::find($id);
            
            if (!$patient) {
                return $this->createOperationOutcome('error', 'not-found', "Patient with ID {$id} not found", 404);
            }
            
            $fhirData = $request->all();
            
            // Validate FHIR resource type
            if (!isset($fhirData['resourceType']) || $fhirData['resourceType'] !== 'Patient') {
                return $this->createOperationOutcome('error', 'invalid', 'Invalid resourceType. Expected: Patient');
            }
            
            // Extract data from FHIR format
            $name = $fhirData['name'][0] ?? null;
            $telecom = $fhirData['telecom'] ?? [];
            $address = $fhirData['address'][0] ?? null;
            
            // Update patient data
            $updateData = [];
            
            if ($name && isset($name['family']) && isset($name['given'][0])) {
                $updateData['nama_lengkap'] = $name['given'][0] . ' ' . $name['family'];
            }
            
            $phone = null;
            foreach ($telecom as $contact) {
                if ($contact['system'] === 'phone') {
                    $phone = $contact['value'];
                    break;
                }
            }
            if ($phone) {
                $updateData['no_hp'] = $phone;
            }
            
            $email = $this->extractEmail($telecom);
            if ($email) {
                $updateData['email'] = $email;
            }
            
            if ($address && isset($address['text'])) {
                $updateData['alamat'] = $address['text'];
            }
            
            $patient->update($updateData);
            
            return response()->json(new PatientResource($patient), 200);
            
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * DELETE /fhir/Patient/{id}
     * Delete patient (soft delete)
     */
    public function deletePatient($id)
    {
        try {
            $patient = Patient::find($id);
            
            if (!$patient) {
                return $this->createOperationOutcome('error', 'not-found', "Patient with ID {$id} not found", 404);
            }
            
            $patient->delete(); // Soft delete
            
            return response()->json([
                'resourceType' => 'OperationOutcome',
                'issue' => [[
                    'severity' => 'information',
                    'code' => 'informational',
                    'diagnostics' => "Patient with ID {$id} successfully deleted"
                ]]
            ], 200);
            
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * PATCH /fhir/Patient/{id}
     * Partially update patient (only provided fields)
     */
    public function patchPatient(Request $request, $id)
    {
        // PATCH is same as PUT for FHIR (both do partial updates)
        // But PATCH is more explicit about partial updates
        return $this->updatePatient($request, $id);
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
     * POST /fhir/Appointment
     * Create new appointment in FHIR format
     */
    public function createAppointment(Request $request)
    {
        try {
            $fhirData = $request->all();
            
            // Validate FHIR resource type
            if (!isset($fhirData['resourceType']) || $fhirData['resourceType'] !== 'Appointment') {
                return $this->createOperationOutcome('error', 'invalid', 'Invalid resourceType. Expected: Appointment');
            }
            
            // Extract patient reference
            $patientRef = null;
            foreach ($fhirData['participant'] ?? [] as $participant) {
                if (isset($participant['actor']['reference']) && str_starts_with($participant['actor']['reference'], 'Patient/')) {
                    $patientRef = intval(str_replace('Patient/', '', $participant['actor']['reference']));
                    break;
                }
            }
            
            if (!$patientRef) {
                return $this->createOperationOutcome('error', 'required', 'Missing required field: participant (Patient reference)');
            }
            
            // Validate patient exists
            if (!Patient::find($patientRef)) {
                return $this->createOperationOutcome('error', 'not-found', "Patient with ID {$patientRef} not found");
            }
            
            // Extract dates
            $start = $fhirData['start'] ?? null;
            if (!$start) {
                return $this->createOperationOutcome('error', 'required', 'Missing required field: start');
            }
            
            $startDate = \Carbon\Carbon::parse($start);
            
            // Create appointment
            $appointment = Appointment::create([
                'patient_id' => $patientRef,
                'tanggal_diminta' => $startDate->format('Y-m-d'),
                'jam_diminta' => $startDate->format('H:i'),
                'keluhan' => $fhirData['description'] ?? null,
                'status' => $fhirData['status'] ?? 'pending',
            ]);
            
            return response()->json(new AppointmentResource($appointment), 201)
                ->header('Location', url("/api/fhir/Appointment/{$appointment->id}"));
                
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * PUT /fhir/Appointment/{id}
     * Update existing appointment in FHIR format
     */
    public function updateAppointment(Request $request, $id)
    {
        try {
            $appointment = Appointment::find($id);
            
            if (!$appointment) {
                return $this->createOperationOutcome('error', 'not-found', "Appointment with ID {$id} not found", 404);
            }
            
            $fhirData = $request->all();
            
            // Validate FHIR resource type
            if (!isset($fhirData['resourceType']) || $fhirData['resourceType'] !== 'Appointment') {
                return $this->createOperationOutcome('error', 'invalid', 'Invalid resourceType. Expected: Appointment');
            }
            
            $updateData = [];
            
            // Update status
            if (isset($fhirData['status'])) {
                $updateData['status'] = $fhirData['status'];
            }
            
            // Update description (keluhan)
            if (isset($fhirData['description'])) {
                $updateData['keluhan'] = $fhirData['description'];
            }
            
            // Update start date/time
            if (isset($fhirData['start'])) {
                $startDate = \Carbon\Carbon::parse($fhirData['start']);
                $updateData['tanggal_diminta'] = $startDate->format('Y-m-d');
                $updateData['jam_diminta'] = $startDate->format('H:i');
            }
            
            $appointment->update($updateData);
            
            return response()->json(new AppointmentResource($appointment), 200);
            
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * DELETE /fhir/Appointment/{id}
     * Delete appointment (soft delete)
     */
    public function deleteAppointment($id)
    {
        try {
            $appointment = Appointment::find($id);
            
            if (!$appointment) {
                return $this->createOperationOutcome('error', 'not-found', "Appointment with ID {$id} not found", 404);
            }
            
            $appointment->delete(); // Soft delete
            
            return response()->json([
                'resourceType' => 'OperationOutcome',
                'issue' => [[
                    'severity' => 'information',
                    'code' => 'informational',
                    'diagnostics' => "Appointment with ID {$id} successfully deleted"
                ]]
            ], 200);
            
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * PATCH /fhir/Appointment/{id}
     * Partially update appointment (only provided fields)
     */
    public function patchAppointment(Request $request, $id)
    {
        return $this->updateAppointment($request, $id);
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
     * POST /fhir/Condition
     * Create new condition (medical diagnosis) in FHIR format
     */
    public function createCondition(Request $request)
    {
        try {
            $fhirData = $request->all();
            
            // Validate FHIR resource type
            if (!isset($fhirData['resourceType']) || $fhirData['resourceType'] !== 'Condition') {
                return $this->createOperationOutcome('error', 'invalid', 'Invalid resourceType. Expected: Condition');
            }
            
            // Extract patient reference
            $patientRef = null;
            if (isset($fhirData['subject']['reference']) && str_starts_with($fhirData['subject']['reference'], 'Patient/')) {
                $patientRef = intval(str_replace('Patient/', '', $fhirData['subject']['reference']));
            }
            
            if (!$patientRef) {
                return $this->createOperationOutcome('error', 'required', 'Missing required field: subject (Patient reference)');
            }
            
            // Validate patient exists
            if (!Patient::find($patientRef)) {
                return $this->createOperationOutcome('error', 'not-found', "Patient with ID {$patientRef} not found");
            }
            
            // Extract diagnosis
            $diagnosis = $fhirData['code']['text'] ?? $fhirData['code']['coding'][0]['display'] ?? null;
            if (!$diagnosis) {
                return $this->createOperationOutcome('error', 'required', 'Missing required field: code (diagnosis)');
            }
            
            // Create medical record with diagnosis
            $record = MedicalRecord::create([
                'patient_id' => $patientRef,
                'no_rm' => $this->generateRM(),
                'tanggal_masuk' => now()->format('Y-m-d'),
                'keluhan' => $fhirData['notes'] ?? null,
                'diagnosa' => $diagnosis,
            ]);
            
            return response()->json(new ConditionResource($record), 201)
                ->header('Location', url("/api/fhir/Condition/{$record->id}"));
                
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * PUT /fhir/Condition/{id}
     * Update existing condition in FHIR format
     */
    public function updateCondition(Request $request, $id)
    {
        try {
            $record = MedicalRecord::find($id);
            
            if (!$record) {
                return $this->createOperationOutcome('error', 'not-found', "Condition with ID {$id} not found", 404);
            }
            
            $fhirData = $request->all();
            
            // Validate FHIR resource type
            if (!isset($fhirData['resourceType']) || $fhirData['resourceType'] !== 'Condition') {
                return $this->createOperationOutcome('error', 'invalid', 'Invalid resourceType. Expected: Condition');
            }
            
            $updateData = [];
            
            // Update diagnosis
            if (isset($fhirData['code'])) {
                $diagnosis = $fhirData['code']['text'] ?? $fhirData['code']['coding'][0]['display'] ?? null;
                if ($diagnosis) {
                    $updateData['diagnosa'] = $diagnosis;
                }
            }
            
            // Update notes (keluhan)
            if (isset($fhirData['notes'])) {
                $updateData['keluhan'] = $fhirData['notes'];
            }
            
            $record->update($updateData);
            
            return response()->json(new ConditionResource($record), 200);
            
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * DELETE /fhir/Condition/{id}
     * Delete condition (soft delete)
     */
    public function deleteCondition($id)
    {
        try {
            $record = MedicalRecord::find($id);
            
            if (!$record) {
                return $this->createOperationOutcome('error', 'not-found', "Condition with ID {$id} not found", 404);
            }
            
            $record->delete(); // Soft delete
            
            return response()->json([
                'resourceType' => 'OperationOutcome',
                'issue' => [[
                    'severity' => 'information',
                    'code' => 'informational',
                    'diagnostics' => "Condition with ID {$id} successfully deleted"
                ]]
            ], 200);
            
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * PATCH /fhir/Condition/{id}
     * Partially update condition (only provided fields)
     */
    public function patchCondition(Request $request, $id)
    {
        return $this->updateCondition($request, $id);
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
     * POST /fhir/Procedure
     * Create new procedure (medical treatment) in FHIR format
     */
    public function createProcedure(Request $request)
    {
        try {
            $fhirData = $request->all();
            
            // Validate FHIR resource type
            if (!isset($fhirData['resourceType']) || $fhirData['resourceType'] !== 'Procedure') {
                return $this->createOperationOutcome('error', 'invalid', 'Invalid resourceType. Expected: Procedure');
            }
            
            // Extract patient reference
            $patientRef = null;
            if (isset($fhirData['subject']['reference']) && str_starts_with($fhirData['subject']['reference'], 'Patient/')) {
                $patientRef = intval(str_replace('Patient/', '', $fhirData['subject']['reference']));
            }
            
            if (!$patientRef) {
                return $this->createOperationOutcome('error', 'required', 'Missing required field: subject (Patient reference)');
            }
            
            // Validate patient exists
            if (!Patient::find($patientRef)) {
                return $this->createOperationOutcome('error', 'not-found', "Patient with ID {$patientRef} not found");
            }
            
            // Extract procedure
            $procedure = $fhirData['code']['text'] ?? $fhirData['code']['coding'][0]['display'] ?? null;
            if (!$procedure) {
                return $this->createOperationOutcome('error', 'required', 'Missing required field: code (procedure)');
            }
            
            // Create medical record with procedure
            $record = MedicalRecord::create([
                'patient_id' => $patientRef,
                'no_rm' => $this->generateRM(),
                'tanggal_masuk' => now()->format('Y-m-d'),
                'tindakan' => $procedure,
                'keluhan' => $fhirData['reasonCode'][0]['text'] ?? null,
            ]);
            
            return response()->json(new ProcedureResource($record), 201)
                ->header('Location', url("/api/fhir/Procedure/{$record->id}"));
                
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * PUT /fhir/Procedure/{id}
     * Update existing procedure in FHIR format
     */
    public function updateProcedure(Request $request, $id)
    {
        try {
            $record = MedicalRecord::find($id);
            
            if (!$record) {
                return $this->createOperationOutcome('error', 'not-found', "Procedure with ID {$id} not found", 404);
            }
            
            $fhirData = $request->all();
            
            // Validate FHIR resource type
            if (!isset($fhirData['resourceType']) || $fhirData['resourceType'] !== 'Procedure') {
                return $this->createOperationOutcome('error', 'invalid', 'Invalid resourceType. Expected: Procedure');
            }
            
            $updateData = [];
            
            // Update procedure
            if (isset($fhirData['code'])) {
                $procedure = $fhirData['code']['text'] ?? $fhirData['code']['coding'][0]['display'] ?? null;
                if ($procedure) {
                    $updateData['tindakan'] = $procedure;
                }
            }
            
            // Update reason (keluhan)
            if (isset($fhirData['reasonCode'][0]['text'])) {
                $updateData['keluhan'] = $fhirData['reasonCode'][0]['text'];
            }
            
            $record->update($updateData);
            
            return response()->json(new ProcedureResource($record), 200);
            
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * DELETE /fhir/Procedure/{id}
     * Delete procedure (soft delete)
     */
    public function deleteProcedure($id)
    {
        try {
            $record = MedicalRecord::find($id);
            
            if (!$record) {
                return $this->createOperationOutcome('error', 'not-found', "Procedure with ID {$id} not found", 404);
            }
            
            $record->delete(); // Soft delete
            
            return response()->json([
                'resourceType' => 'OperationOutcome',
                'issue' => [[
                    'severity' => 'information',
                    'code' => 'informational',
                    'diagnostics' => "Procedure with ID {$id} successfully deleted"
                ]]
            ], 200);
            
        } catch (\Exception $e) {
            return $this->createOperationOutcome('error', 'exception', $e->getMessage(), 500);
        }
    }

    /**
     * PATCH /fhir/Procedure/{id}
     * Partially update procedure (only provided fields)
     */
    public function patchProcedure(Request $request, $id)
    {
        return $this->updateProcedure($request, $id);
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

    /**
     * =====================================
     * HELPER METHODS
     * =====================================
     */
    
    /**
     * Create FHIR OperationOutcome for errors
     */
    private function createOperationOutcome($severity, $code, $diagnostics, $status = 400)
    {
        return response()->json([
            'resourceType' => 'OperationOutcome',
            'issue' => [[
                'severity' => $severity,
                'code' => $code,
                'diagnostics' => $diagnostics
            ]]
        ], $status);
    }

    /**
     * Extract email from FHIR telecom array
     */
    private function extractEmail($telecom)
    {
        foreach ($telecom as $contact) {
            if (isset($contact['system']) && $contact['system'] === 'email') {
                return $contact['value'];
            }
        }
        return null;
    }

    /**
     * Generate unique 5-digit medical record number
     */
    private function generateRM()
    {
        do {
            $no_rm = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (MedicalRecord::where('no_rm', $no_rm)->exists());
        
        return $no_rm;
    }
}
