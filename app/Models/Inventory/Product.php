<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Product extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $fillable = array('id', 'title', 'slug', 'summary', 'description', 'photo', 'stock', 'condition', 'status', 'price', 'discount', 'is_featured', 'cat_id', 'child_cat_id', 'brand_id', 'created_at', 'updated_at', 'created_by', 'deleted_by', 'deleted_at');

    public function admin(){
        return $this->belongsTo('App\Models\User', 'admin_id', 'id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Shop\Category', 'cat_id', 'id');
    }
    
    public function child_category(){
        return $this->belongsTo('App\Models\Shop\Category', 'child_cat_id', 'id');
    }
    
    public function colours(){
    	return $this->hasMany('App\Models\Shop\ProductColour', 'product_id', 'id');
	}

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
	}

    public function deleter(){
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');
    }

    public function images(){
    	return $this->hasMany('App\Models\Shop\ProductImage', 'product_id', 'id');
	}
    
    public function sizes(){
        return $this->hasMany('App\Models\Inventory\ProductSize', 'product_id', 'id');
    }
}

