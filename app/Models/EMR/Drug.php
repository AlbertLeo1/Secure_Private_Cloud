<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Drug extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_drugs';
    protected $fillable = array('id', 'name', );

    public function details(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

    public function forms(){
    	return $this->hasMany('App\Models\EMR\DrugForm', 'drug_id', 'id');
	}

    public function hospital(){
    	return $this->belongsTo('App\Models\EMR\Hospital', 'hospital_id', 'id');
	}
}
