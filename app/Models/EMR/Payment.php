<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'emr_payments';
    protected $fillable = array('service_id', 'patient_id', 'appointment_id', 'amount', 'employee_id', 'channel', 'details', 'created_at', 'updated_at');

    public function patient(){
    	return $this->belongsTo('App\Models\User', 'patient_id', 'id');
	}

    public function appointment(){
    	return $this->belongsTo('App\Models\EMR\Appointment', 'appointment_id', 'id');
	}

    public function employee(){
    	return $this->belongsTo('App\Models\User', 'employee_id', 'id');
	}

    public function service(){
    	return $this->belongsTo('App\Models\EMR\Service', 'service_id', 'id');
	}
}