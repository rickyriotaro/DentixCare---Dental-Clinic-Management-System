<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientControl extends Model
{
    protected $fillable = [
        'medical_record_id','dokter_id',
        'tanggal_kontrol','jam_kontrol',
        'status','catatan'
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

  public function dokter()
{
    return $this->belongsTo(User::class, 'dokter_id');
}
}
