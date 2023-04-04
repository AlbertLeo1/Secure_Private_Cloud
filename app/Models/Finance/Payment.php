<?php

namespace App\Models\Finance;

use App\Models\Structure;

class Payment extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'finance_payments';
    protected $fillable = array('date', 'item_name', 'item_qty', 'item_unit_cost', 'item_total', 'description', 'user_id', 'status',  'deleted_by', 'deleted_at');
}
