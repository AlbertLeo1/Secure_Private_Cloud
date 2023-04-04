<?php

namespace App\Models\Inventory;

use App\Models\Structure;

class Returnee extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'returns';
    protected $fillable = array('sales_id', 'code', 'customer_id', 'date', 'admin_id', 'status');

    public function returned_items(){
    	return $this->hasMany('App\Models\Inventory\ReturnItem', 'category_id', 'id');
    }

    public function sales_order(){
    	return $this->hasMany('App\Models\Inventory\Product', 'category_id', 'id');
    }
}