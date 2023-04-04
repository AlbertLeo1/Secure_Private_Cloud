<?php

namespace App\Models\Inventory;
use App\Models\Structure;

class Bundle extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'bundles';
    protected $fillable = array('name', 'code', 'price', 'cost', 'category_id', 'description', 'status', 'created_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');

    public function admin(){
        return $this->belongsTo('App\Models\User', 'admin_id', 'id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Inventory\ProductCategory', 'category_id', 'id');
    }

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
	}

    public function deleter(){
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');
    }

    public function bundle_items(){
        return $this->hasMany('App\Models\Inventory\BundleItems', 'bundle_id', 'id');
    }

}