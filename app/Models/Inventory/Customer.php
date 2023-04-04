<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_type', 'company_name', 'display_name', 'alt_website', 'cp_title', 'cp_first_name', 'cp_last_name', 'cp_other_name', 'cp_email', 'cp_phone', 'unique_id', 'image', 'street', 'street2', 'city', 'area_id', 'state_id', 'phone', 'dob', 'email', 'email_verified_at', 'website', 'remember_token', 'created_at', 'created_by', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'
    ];

    public function area(){
        return $this->belongsTo('App\Models\User\Area', 'area_id', 'id');
    }

    public function contact_persons(){
        return $this->hasMany('App\Models\Inventory\CustomerContactPerson', 'customer_id', 'id');
    }

    public function state(){
        return $this->belongsTo('App\Models\User\State', 'state_id', 'id');        
    }

    public function purchases(){
        return $this->hasMany('App\Models\Inventory\Purchase', 'customer_id', 'id');
    }
}