<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class DomiliciaryAccessment extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_domiliciary_accessments';
    protected $fillable = array('patient_id', 'start_date', 'end_date', 'status', 'active', 'requested_by', 'acccessed_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function accessment_braden(){
    	return $this->belongsTo('App\Models\EMR\DomiliciaryAccessmentBraden', 'domiliciary_id', 'id');
	}
}