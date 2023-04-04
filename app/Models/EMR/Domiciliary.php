<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class Domiciliary extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_domiliciaries';
    protected $fillable = array('patient_id', 'payment_type', 'start_date', 'end_date', 'status', 'active', 'hca_daily', 'rn_daily', 'bsc_daily', 'requested_by', 'assessed_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');


    public function assessor(){
    	return $this->belongsTo('App\Models\HRMS\Employee', 'assessed_by', 'id');
	}

    public function assessment(){
    	return $this->belongsTo('App\Models\EMR\DomiliciaryAccessment', 'domiliciary_id', 'id');
	}

    public function patient(){
        return $this->belongsTo('App\Models\EMR\Patient', 'patient_id', 'id');
    }

    public function tasks(){
        return $this->hasMany('App\Models\EMR\PatientTask', 'patient_id', 'id');
    }
}
