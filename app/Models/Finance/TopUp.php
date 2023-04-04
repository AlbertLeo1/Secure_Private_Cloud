<?php

namespace App\Models\Finance;

use App\Models\Structure;

class TopUp extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'finance_topups';
    protected $fillable = array('user_id', 'amount', 'channel', 'date', 'status', 'deleted_by', 'deleted_at');
}