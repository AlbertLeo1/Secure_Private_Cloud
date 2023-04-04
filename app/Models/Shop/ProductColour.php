<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductColour extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_colours';
    protected $fillable = array('product_id', 'colour_id', 'created_at', 'updated_at', 'created_by', 'deleted_by', 'deleted_at');

    public function colour(){
    	return $this->belongsTo('App\Models\Shop\Colour', 'colour_id', 'id');
	}
}