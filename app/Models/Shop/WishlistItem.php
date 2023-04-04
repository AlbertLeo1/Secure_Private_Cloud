<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'wishlist_items';
    protected $fillable = array('user_id', 'product_id', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function product(){
    	return $this->belongsTo('App\Models\Shop\Product', 'product_id', 'id');
	}
}