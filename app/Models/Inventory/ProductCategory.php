<?php

namespace App\Models\Inventory;

use App\Models\Structure;

class ProductCategory extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'categories';
    protected $fillable = array('name', 'parent_id',);

    public function pry_category(){
        return $this->belongsTo('App\Models\Inventory\ProductCategory', 'parent_id', 'id');
    }
    
    public function products(){
    	return $this->hasMany('App\Models\Inventory\Product', 'category_id', 'id');
    }
}
