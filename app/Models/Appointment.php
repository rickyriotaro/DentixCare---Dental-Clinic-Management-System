<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\User;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'dokter_id',
        'tanggal_diminta',
        'jam_diminta',
        'keluhan',
        'tanggal_dikonfirmasi',
        'jam_dikonfirmasi',
        'status',
    ];

     public function patient()
    {
        return $this->belongsTo(
            Patient::class,
            'patient_id', // FK di appointments
            'id'          // PK di patients
        );
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}
