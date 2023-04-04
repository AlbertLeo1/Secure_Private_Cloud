<?php

namespace App\Models\SOM;

use App\Models\Structure;

class Winner extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'staff_month_winners';
    protected $fillable = array('user_id', 'branch_id', 'month_id', 'created_by', 'updated_by', 'deleted_by', 'deleted_at');

    public function branch(){
    	return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
	}
    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}
}