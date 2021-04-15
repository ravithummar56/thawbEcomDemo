<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class Order extends BaseModel
{
    protected $table = 'orders';

    public function orderItems()
	{
		 return $this->hasMany('App\Models\OrderItems','order_id','id');
	}

	public function customerDetails()
	{
		 return $this->belongsTo('App\Models\User','user_id');
	}

	public function customerAddress()
	{
		 return $this->belongsTo('App\Models\CustomerAddress','user_id','user_id');
	}

	public function orderStatus()
	{
		return $this->belongsTo('App\Models\OrderStatus','order_status_id');
	}

	public function paymentStatus()
	{
		return $this->belongsTo('App\Models\PaymentStatus','payments_status_id');
	}

	public function billAddress()
	{
		return $this->belongsTo('App\Models\CustomerAddress','billing_address_id');
	}

	public function shipaddress()
	{
		return $this->belongsTo('App\Models\CustomerAddress','shipping_address_id');
	}
}



