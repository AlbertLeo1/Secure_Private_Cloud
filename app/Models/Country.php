<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'nations';
    protected $fillable = array('name', 'continent', 'created_at', 'updated_at', 'deleted_at');
	
	public function chief_consultant(){
		return $this->belongsTo('App\Models\User', 'cinc_id', 'id');
	}
}
