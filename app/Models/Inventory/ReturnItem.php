<?php

namespace App\Models\Inventory;

use App\Models\Structure;

class ReturnItem extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'returns';
    protected $fillable = array('id', 'return_id', 'receiver_id', 'product_id', 'date', 'reason', 'others', 'details', 'received_note', 'deleted_by');

    public function returnee(){
    	return $this->belongsTo('App\Models\Inventory\Returnee', 'return_id', 'id');
    }
    
}
