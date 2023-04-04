<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class Appointment extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_appointments';
    protected $fillable = array('id', 'patient_id', 'service_id', 'date', 'schedule', 'status', 'arrived_at', 'payment_channel', 'paid_by', 'created_at', 'deleted_by', 'deleted_at');

    public function patient(){
        return $this->belongsTo('App\Models\User', 'patient_id', 'id');
    }

    public function service(){
        return $this->belongsTo('App\Models\EMR\Service', 'service_id', 'id');
    }

    public function radiologist(){
        return $this->belongsTo('App\Models\User', 'radiologist_id', 'id');
    }
    
    public function doctor(){
        return $this->belongsTo('App\Models\User', 'doctor_id', 'id');
    }
    
    public function front_officer(){
        return $this->belongsTo('App\Models\User', 'front_officer_id', 'id');
    }

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
	}

    public function mo(){
        return $this->belongsTo('App\Models\EMR\Doctor', 'doctor_id', 'id');
    }
    
    public function deleter(){
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');
    }

    public function payment(){
    	return $this->belongsTo('App\Models\EMR\Payment', 'id', 'appointment_id');
	}
}