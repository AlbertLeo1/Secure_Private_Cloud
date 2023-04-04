<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class DoctorSpeciality extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_doctor_specialities';
    protected $fillable = array('name', 'created_at', 'deleted_by', 'deleted_at');
}