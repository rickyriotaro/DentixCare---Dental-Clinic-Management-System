<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'patient_id',
        'no_hp',
        'jenis',
        'judul',
        'pesan',
        'status',
        'related_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
