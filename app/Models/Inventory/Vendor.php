<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'vendors';
    protected $fillable = array('name', 'address', 'city', 'area_id', 'state_id', 'phone', 'alt_phone', 'email', 'website', 'contact_person', 'cp_phone', 'cp_email', 'created_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');

    public function creator(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }    
}