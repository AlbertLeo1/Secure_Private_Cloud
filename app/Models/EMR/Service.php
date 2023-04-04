<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Service extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_services';
    protected $fillable = array('id',  'name', 'price', 'status', 'created_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

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