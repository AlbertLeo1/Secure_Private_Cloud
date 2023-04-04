<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'banks';
    protected $fillable = array('name', 'bank_name', 'purpose', 'status', 'number'); 
}