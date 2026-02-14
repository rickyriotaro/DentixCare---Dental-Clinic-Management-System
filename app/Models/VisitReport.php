<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitReport extends Model
{
    protected $fillable = ['user_id','from_date','to_date','nama_pasien','keluhan','riwayat_penyakit','total'];

public function items() {
  return $this->hasMany(VisitReportItem::class);
}

}
