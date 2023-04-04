<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Prescription extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_prescriptions';
    protected $fillable = array('appointment_id', 'patient_id', 'doctor_id', 'doctor_name', 'status', 'start_date', 'end_date', 'created_by', 'deleted_by', 'deleted_at');

    public function doctor(){
    	return $this->belongsTo('App\Models\EMR\Doctor', 'doctor_id', 'id');
	}

    public function patient(){
    	return $this->belongsTo('App\Models\User', 'patient_id', 'id');
	}

    public function drugs(){
        return $this->hasMany('App\Models\EMR\PrescriptionDrug', 'prescription_id', 'id');
    }
}
