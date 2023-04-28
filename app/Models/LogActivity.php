<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user_log_activities';
    protected $fillable = array('subject', 'url', 'method', 'ip', 'agent', 'user_id');
	
    public function user(){
		return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}
	
	public function hod(){
		return $this->belongsTo('App\Models\User', 'hod_id', 'id');
	}
}
