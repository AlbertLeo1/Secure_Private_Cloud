<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment  extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'payments';
    protected $fillable = array('user_id', 'amount', 'ref_id', 'payment_type', 'date', 'trans_type', 'trans_admin_id', 'bank_id', 'bank_trans_id', 'admin_id', 'admin_description', 'description', 'status', 'confirm_at');

    public function bank(){
    	return $this->belongsTo('App\Models\Bank', 'bank_id', 'id');
		}
	
	public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
		}

	public function repayment(){
    	return $this->belongsTo('App\Models\Repayment', 'ref_id', 'id');
		}

	public function contribution(){
    	return $this->belongsTo('App\Models\Contribution', 'ref_id', 'id');
		}

	public function confirmed_by(){
    	return $this->belongsTo('App\Models\User', 'admin_id', 'id');
		}

	public function paid_to(){
    	return $this->belongsTo('App\Models\User', 'trans_admin_id', 'id');
		}
	}