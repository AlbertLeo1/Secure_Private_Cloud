<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class Category extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'course_categories';
    protected $fillable = array('name', 'description', 'status');
    public function sub_categories(){
    	return $this->hasMany('App\Models\Lms\SubCategory', 'category_id', 'id'); 
		}
	}