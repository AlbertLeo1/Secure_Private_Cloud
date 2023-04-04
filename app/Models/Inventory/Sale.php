<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Sale extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'sales';
    protected $fillable = array('purchase_date', 'delivery_date', 'payment_status', 'requested_by', 'amount', 'discount', 'customer_id', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'); 
    
    public function customer(){
    	return $this->belongsTo('App\Models\User', 'customer_id', 'id');
    }

    public function sales_items(){
    	return $this->hasMany('App\Models\Inventory\SaleItem', 'sale_id', 'id');
    }
}