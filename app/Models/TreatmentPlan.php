<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentPlan extends Model
{
    protected $fillable = [
        'medical_record_id',
        'patient_id',
        'dokter_id',
        'tanggal_rencana',
        'jam_rencana',
        'judul',
        'rencana',
        'catatan',
        'status',
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}
