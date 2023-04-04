<?php

namespace App\Models\Inventory;

use App\Models\Structure;

class CustomerContactPerson extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'customer_contact_persons';
    protected $fillable = ['customer_id', 'cp_title', 'cp_first_name', 'cp_last_name', 'cp_phone', 'cp_email', 'pry_contact'];

    public function customer(){
        return $this->belongsTo('App\Models\Inventory\Customer', 'customer_id', 'id');
    }
}