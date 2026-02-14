<?php

namespace App\Http\Resources\FHIR;

use Illuminate\Http\Resources\Json\JsonResource;

class ConditionResource extends JsonResource
{
    /**
     * Disable data wrapping for FHIR compliance
     */
    public static $wrap = null;

    /**
     * Transform MedicalRecord Diagnosis to FHIR Condition Resource
     * Spec: http://hl7.org/fhir/condition.html
     */
    public function toArray($request)
    {
        return [
            'resourceType' => 'Condition',
            'id' => 'cond-' . $this->id,
            'clinicalStatus' => [
                'coding' => [
                    [
                        'system' => 'http://terminology.hl7.org/CodeSystem/condition-clinical',
                        'code' => 'active'
                    ]
                ]
            ],
            'verificationStatus' => [
                'coding' => [
                    [
                        'system' => 'http://terminology.hl7.org/CodeSystem/condition-ver-status',
                        'code' => 'confirmed'
                    ]
                ]
            ],
            'category' => [
                [
                    'coding' => [
                        [
                            'system' => 'http://terminology.hl7.org/CodeSystem/condition-category',
                            'code' => 'encounter-diagnosis',
                            'display' => 'Encounter Diagnosis'
                        ]
                    ]
                ]
            ],
            'code' => [
                'coding' => [
                    [
                        'system' => 'http://snomed.info/sct',
                        'code' => '709564005',
                        'display' => 'Tooth and/or associated structures disease'
                    ]
                ],
                'text' => $this->diagnosis ?? $this->diagnosa ?? 'Penyakit gigi'
            ],
            'subject' => [
                'reference' => 'Patient/' . $this->patient_id,
                'display' => $this->patient->nama_lengkap ?? 'Unknown Patient'
            ],
            'encounter' => [
                'reference' => 'MedicalRecord/' . $this->id,
                'display' => 'No. RM: ' . $this->no_rm
            ],
            'recordedDate' => $this->tanggal_masuk ?? $this->tanggal_periksa ?? $this->created_at->toDateString(),
            'recorder' => $this->dokter_id ? [
                'reference' => 'Practitioner/' . $this->dokter_id,
                'display' => $this->dokter->name ?? 'Unknown Doctor'
            ] : null,
            'note' => array_filter([
                $this->keluhan ? [
                    'text' => 'Keluhan: ' . $this->keluhan
                ] : null,
                $this->alergi ? [
                    'text' => 'Alergi: ' . $this->alergi
                ] : null,
                $this->riwayat_penyakit ? [
                    'text' => 'Riwayat Penyakit: ' . $this->riwayat_penyakit
                ] : null,
            ]),
            'meta' => [
                'lastUpdated' => $this->updated_at ? $this->updated_at->toIso8601String() : now()->toIso8601String(),
            ]
        ];
    }
}
