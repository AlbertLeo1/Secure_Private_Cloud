<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class SubCategory extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'course_sub_categories';
    protected $fillable = array('name', 'description', 'status', 'category_id');
    public function category(){
    	return $this->belongsTo('App\Models\Lms\Category', 'id', 'category_id'); 
		}
	}
