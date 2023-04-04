<?php 
namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class PaymentOption extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'payment_options';
    protected $fillable = array('name');

}