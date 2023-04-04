<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'states';
    protected $fillable = array('name');

    public function areas(){
        return $this->hasMany('App\Models\Area', 'state_id', 'id');
        }

	}
