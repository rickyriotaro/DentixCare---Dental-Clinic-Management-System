<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitReportItem extends Model
{
    protected $fillable = [
  'visit_report_id','medical_record_id','no_rm','nama_pasien','alamat','tanggal_masuk',
  'keluhan','alergi','riwayat_penyakit','rencana_perawatan'
];

}
