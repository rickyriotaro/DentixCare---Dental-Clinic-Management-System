<?php

namespace App\Http\Resources\FHIR;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProcedureResource extends JsonResource
{
    /**
     * Disable data wrapping for FHIR compliance
     */
    public static $wrap = null;

    /**
     * Transform Medical Record to FHIR Procedure Resource
     * Spec: http://hl7.org/fhir/procedure.html
     */
    public function toArray($request)
    {
        return [
            'resourceType' => 'Procedure',
            'id' => 'proc-' . $this->id,
            'status' => 'completed',
            'category' => [
                'coding' => [
                    [
                        'system' => 'http://snomed.info/sct',
                        'code' => '387713003',
                        'display' => 'Surgical procedure'
                    ]
                ]
            ],
            'code' => [
                'coding' => [
                    [
                        'system' => 'http://snomed.info/sct',
                        'code' => '108290001',
                        'display' => 'Dental procedure'
                    ]
                ],
                'text' => $this->tindakan ?? 'Tindakan gigi'
            ],
            'subject' => [
                'reference' => 'Patient/' . $this->patient_id,
                'display' => $this->patient->nama_lengkap ?? 'Unknown Patient'
            ],
            'encounter' => [
                'reference' => 'MedicalRecord/' . $this->id,
                'display' => 'No. RM: ' . $this->no_rm
            ],
            'performedDateTime' => $this->tanggal_masuk ?? $this->tanggal_periksa ?? $this->created_at->toIso8601String(),
            'performer' => $this->dokter_id ? [
                [
                    'actor' => [
                        'reference' => 'Practitioner/' . $this->dokter_id,
                        'display' => $this->dokter->name ?? 'Unknown Doctor'
                    ]
                ]
            ] : [],
            'note' => array_filter([
                $this->tindakan ? [
                    'text' => 'Tindakan: ' . $this->tindakan
                ] : null,
                $this->resep_obat ? [
                    'text' => 'Resep Obat: ' . $this->resep_obat
                ] : null,
                $this->catatan ? [
                    'text' => 'Catatan: ' . $this->catatan
                ] : null,
            ]),
            'meta' => [
                'lastUpdated' => $this->updated_at ? $this->updated_at->toIso8601String() : now()->toIso8601String(),
            ]
        ];
    }
}
