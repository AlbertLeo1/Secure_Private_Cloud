<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Payment extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'payments';
    protected $fillable = array('date', 'customer_id', 'amount', 'payment_type_id', 'for', 'ref_id', );

    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }
    
    public function sale(){
    	return $this->belongsTo('App\Models\Inventory\Sale', 'ref_id', 'id');
    }
}