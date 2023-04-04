<?php


namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;


class Purchase extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'purchases';
    protected $fillable = array('request_date', 'approved_date', 'issued_date', 'delivery_date', 'payment_date', 'payment_status', 'purchase_status', 'vendor_id', 'discount', 'discount_amount', 'requested_by');

    public function vendor(){
        return $this->belongsTo('App\Models\Inventory\Vendor', 'vendor_id', 'id');
    }
    
    public function items(){
    	return $this->hasMany('App\Models\Inventory\PurchaseItem', 'purchase_id', 'id');
    }
}