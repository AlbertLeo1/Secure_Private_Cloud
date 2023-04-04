<?php

namespace App\Models\SOM;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Month extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'staff_months';
    protected $fillable = array('month', 'nomination_start', 'nomination_end', 'voting_start', 'voting_end', 'nomination_end_id', 'nominate_initiate_id', 'voting_initiate_id', 'voting_end_id', 'created_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function winners(){
    	return $this->hasMany('App\Models\SOM\Winner', 'month_id', 'id');
	}
    
    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
	}

    public function voting_ender(){
    	return $this->belongsTo('App\Models\User', 'voting_end_id', 'id');
	}
}
