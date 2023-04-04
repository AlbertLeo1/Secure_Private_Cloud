<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Certificate extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'certificates';
    protected $fillable = array( 'certificate_code', 'course_id', 'user_id', 'score', 'scorable', 'grade', 'achieved_on', 'expiry_date');
	
    public function user(){
    	return $this->belongsTo('App\Models\User', 'id', 'user_id'); 
		}
	}