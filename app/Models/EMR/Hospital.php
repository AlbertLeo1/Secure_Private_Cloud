<?php
namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Hospital extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_hospitals';
    protected $fillable = array('name', 'street', 'street2', 'city', 'area_id', 'state_id', 'country_id', 'sub_status', 'created_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function doctor(){
    	return $this->hasMany('App\Models\EMR\Doctor', 'hospital_id', 'id');
	}

    public function hospital(){
    	return $this->belongsTo('App\Models\EMR\Hospital', 'hospital_id', 'id');
	}

    public function patient(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}
    protected $hidden = [
        'password', 'remember_token', 'pin'
    ];
}
