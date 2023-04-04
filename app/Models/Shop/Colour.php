<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Colour extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'colours';
    protected $fillable = array('id', 'name', 'rgb_code', 'created_at', 'updated_at', 'created_by', 'deleted_by', 'deleted_at');

}
