<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Structure extends Model {
    use SoftDeletes;
    
    public function selectQuery($sql_stmt) {return DB::select($sql_stmt);}

    public function sqlStatement($sql_stmt) {DB::statement($sql_stmt);}
}