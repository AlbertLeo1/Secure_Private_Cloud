<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Product extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_products';
    protected $fillable = array('name', 'type', 'brand', 'category', 'form', 'concentration', 'pack_size', 'unit_price', 'pack_price', 'created_by', 'created_at', 'updated_at', 'deleted_at');

    public function doctor()
    {
        return $this->belongsTo('App\Models\EMR\Doctor', 'doctor_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo('App\Models\User', 'patient_id', 'id');
    }

    public function drugs()
    {
        return $this->hasOne('App\Models\EMR\AppointmentRoom', 'id', 'appointment_id');
    }
}
