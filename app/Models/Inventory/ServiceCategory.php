<?php

namespace App\Models\Inventory;

use App\Models\Structure;

class ServiceCategory extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'service_categories';
    protected $fillable = array('name', 'pry_category_id',);

    public function pry_category(){
        return $this->belongsTo('App\Models\Inventory\ServiceCategory', 'pry_category_id', 'id');
    }
    
    public function products(){
    	return $this->hasMany('App\Models\Inventory\Product', 'category_id', 'id');
    }
}
