<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;


class Purchase extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'purchase_items';
    protected $fillable = array('date', 'pry_category_id',);

    public function pry_category(){
        return $this->belongsTo('App\Models\Inventory\ServiceCategory', 'pry_category_id', 'id');
    }
    
    public function products(){
    	return $this->hasMany('App\Models\Inventory\Product', 'category_id', 'id');
    }
}