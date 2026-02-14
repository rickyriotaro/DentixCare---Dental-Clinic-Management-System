<?php

namespace App\Http\Resources\FHIR;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AppointmentResource extends JsonResource
{
    /**
     * Disable data wrapping for FHIR compliance
     */
    public static $wrap = null;

    /**
     * Transform Appointment to FHIR Appointment Resource
     * Spec: http://hl7.org/fhir/appointment.html
     */
    public function toArray($request)
    {
        // Map status internal ke FHIR status
        $statusMap = [
            'pending' => 'booked',
            'confirmed' => 'booked',
            'completed' => 'fulfilled',
            'cancelled' => 'cancelled',
        ];

        $fhirStatus = $statusMap[$this->status] ?? 'pending';

        // Parse tanggal dan jam
        $startDateTime = null;
        if ($this->tanggal_dikonfirmasi && $this->jam_dikonfirmasi) {
            $startDateTime = Carbon::parse($this->tanggal_dikonfirmasi . ' ' . $this->jam_dikonfirmasi);
        } elseif ($this->tanggal_diminta && $this->jam_diminta) {
            $startDateTime = Carbon::parse($this->tanggal_diminta . ' ' . $this->jam_diminta);
        }

        $endDateTime = $startDateTime ? $startDateTime->copy()->addMinutes(30) : null;

        return [
            'resourceType' => 'Appointment',
            'id' => (string) $this->id,
            'status' => $fhirStatus,
            'appointmentType' => [
                'coding' => [
                    [
                        'system' => 'http://terminology.hl7.org/CodeSystem/v2-0276',
                        'code' => 'ROUTINE',
                        'display' => 'Routine appointment'
                    ]
                ]
            ],
            'description' => $this->keluhan ?? 'Pemeriksaan gigi',
            'start' => $startDateTime ? $startDateTime->toIso8601String() : null,
            'end' => $endDateTime ? $endDateTime->toIso8601String() : null,
            'created' => $this->created_at->toIso8601String(),
            'participant' => array_filter([
                // Pasien
                [
                    'actor' => [
                        'reference' => 'Patient/' . $this->patient_id,
                        'display' => $this->patient->nama_lengkap ?? 'Unknown Patient'
                    ],
                    'required' => 'required',
                    'status' => 'accepted'
                ],
                // Dokter (jika ada)
                $this->dokter_id ? [
                    'actor' => [
                        'reference' => 'Practitioner/' . $this->dokter_id,
                        'display' => $this->dokter->name ?? 'Unknown Doctor'
                    ],
                    'required' => 'required',
                    'status' => 'accepted'
                ] : null,
            ]),
            'comment' => $this->keluhan,
            'meta' => [
                'lastUpdated' => $this->updated_at ? $this->updated_at->toIso8601String() : now()->toIso8601String(),
            ]
        ];
    }
}
