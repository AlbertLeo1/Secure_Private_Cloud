<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class AppointmentFile extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_appointments';
    protected $fillable = array('appointment_id', 'file', 'file_type', 'deleted_by', 'deleted_at');
}
