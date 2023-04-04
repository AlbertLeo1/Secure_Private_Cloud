<?php

namespace App\Models\Finance;

use App\Models\Structure;

class Wallet extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'finance_wallets';
    protected $fillable = array('user_id', 'balance', 'tp_id', 'py_id', 'updated_by', 'deleted_by', 'deleted_at');
}
