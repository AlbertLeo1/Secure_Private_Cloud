<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class AppointmentRoom extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_appointment_rooms';
    protected $fillable = array('appointment_id', 'doctor_id', 'patient_id', 'deleted_by', 'deleted_at');
}
