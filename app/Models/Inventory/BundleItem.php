<?php

namespace App\Models\Inventory;

use App\Models\Structure;

class BundleItem extends Structure
{
    protected $table = 'bundle_items';
    protected $fillable = array('bundle_id', 'ref_id', 'ref_type',);

}