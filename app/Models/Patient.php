<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Patient extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'patients';

    protected $fillable = [
        'nama_lengkap',
        'alamat',
        'no_hp',
        'email',
        'username',
        'password',
        'keluhan',
    ];

    protected $hidden = [
        'password',
    ];

    // Relationships
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id');
    }

    public function treatmentPlans()
    {
        return $this->hasMany(TreatmentPlan::class, 'patient_id');
    }

    public function controls()
    {
        return $this->hasMany(PatientControl::class, 'patient_id');
    }
}
