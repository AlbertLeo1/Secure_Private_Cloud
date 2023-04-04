<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NextOfKin extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'next_of_kins';
    protected $fillable = array('user_id', 'name', 'address', 'phone', 'email', 'relationship');

    
	public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
		}
	}