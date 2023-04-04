<?php

namespace App\Models\Shop;

use App\Models\Structure;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'product_images';
    protected $fillable = array('id', 'product_id', 'source', 'created_at', 'updated_at', 'created_by', 'deleted_by', 'deleted_at');

}
