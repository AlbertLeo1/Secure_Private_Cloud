<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'areas';
    protected $fillable = array('name', 'state_id');
}
