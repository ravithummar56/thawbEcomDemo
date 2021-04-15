<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class CustomerAddress extends BaseModel
{
    protected $table = 'customer_addresses';

    public function stateDetails()
    {
    	return $this->belongsTo('App\Models\State','state_id','id');
    }
}



