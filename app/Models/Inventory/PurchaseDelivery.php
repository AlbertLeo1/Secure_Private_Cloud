<?php
namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;


class PurchaseDelivery extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'purchase_deliveries';
    protected $fillable = array('purchase_item_id', 'quantity', 'date', 'received_by', 'received_at', 'status', 'deleted_by', 'deleted_at');

    public function purchase_item(){
        return $this->belongsTo('App\Models\Inventory\PurchaseItem', 'purchase_item_id', 'id');
    }
    
    public function receiver(){
    	return $this->belongsTo('App\Models\User', 'received_by', 'id');
    }
}