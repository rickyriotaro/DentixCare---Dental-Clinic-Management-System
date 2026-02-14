<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'no_rm',
        'patient_id',
        'tanggal_masuk',
        'keluhan',
        'alergi',
        'riwayat_penyakit',
        'diagnosa',
        'tindakan',
        'resep_obat',
        'catatan',
        'dokter_id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
    public function controls()
{
    return $this->hasMany(\App\Models\PatientControl::class, 'medical_record_id');
}
}
