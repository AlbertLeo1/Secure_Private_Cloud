<?php

namespace App\Models\Shop;

use App\Models\Structure;
//use Illuminate\Database\Eloquent\Model;

class ProductSize extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'product_sizes';
    protected $fillable = array('name', 'code', 'created_at', 'updated_at', 'created_by', 'deleted_by', 'deleted_at');

    public function colour(){
    	return $this->belongsTo('App\Models\Shop\Colour', 'colour_id', 'id');
	}
}
