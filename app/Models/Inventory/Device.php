<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Device extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'inventory_devices';

    protected $fillable = [
        'name', 'brand', 'serial_number', 'unique_code', 'model', 'branch_id', 'description', 'status', 'mac_address', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'
    ];

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id');
    }
}
