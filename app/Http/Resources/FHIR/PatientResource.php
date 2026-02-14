<?php

namespace App\Http\Resources\FHIR;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Disable data wrapping for FHIR compliance
     */
    public static $wrap = null;

    /**
     * Transform Patient to FHIR Patient Resource
     * Spec: http://hl7.org/fhir/patient.html
     */
    public function toArray($request)
    {
        // Parse nama lengkap menjadi family dan given name
        $nameParts = explode(' ', $this->nama_lengkap, 2);
        $givenName = $nameParts[0] ?? '';
        $familyName = $nameParts[1] ?? '';

        return [
            'resourceType' => 'Patient',
            'id' => (string) $this->id,
            'identifier' => [
                [
                    'system' => 'https://dentix.my.id/patient-id',
                    'value' => 'P-' . str_pad($this->id, 6, '0', STR_PAD_LEFT),
                ]
            ],
            'active' => true,
            'name' => [
                [
                    'use' => 'official',
                    'text' => $this->nama_lengkap,
                    'family' => $familyName ?: $this->nama_lengkap,
                    'given' => $givenName ? [$givenName] : [],
                ]
            ],
            'telecom' => array_filter([
                $this->no_hp ? [
                    'system' => 'phone',
                    'value' => $this->no_hp,
                    'use' => 'mobile'
                ] : null,
                $this->email ? [
                    'system' => 'email',
                    'value' => $this->email,
                ] : null,
            ]),
            'address' => $this->alamat ? [
                [
                    'use' => 'home',
                    'text' => $this->alamat,
                    'country' => 'ID'
                ]
            ] : [],
            'meta' => [
                'lastUpdated' => $this->updated_at ? $this->updated_at->toIso8601String() : now()->toIso8601String(),
            ]
        ];
    }
}
