<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportVisit extends Model
{
    protected $table = 'report_visits';
    protected $fillable = ['filters','file_path'];
}
