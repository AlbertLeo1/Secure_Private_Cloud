<?php

namespace App\Models\Shop;

use App\Models\Structure;
//use Illuminate\Database\Eloquent\Model;

class Category extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'shop_categories';
    protected $fillable = array('title', 'slug', 'summary', 'photo', 'is_parent', 'parent_id', 'added_by', 'status', 'deleted_by');

    public function subs(){
    	return $this->hasMany('App\Models\Shop\Category', 'parent_id', 'id');
	}
}
