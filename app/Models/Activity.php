<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'activities';
    protected $fillable = array('activity_type_id', 'details', 'user_id', 'ref_id', 'deleted_by', 'deleted_at');

    public function author(){
      return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
