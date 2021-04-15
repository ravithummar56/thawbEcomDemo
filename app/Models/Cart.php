<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class Cart extends BaseModel
{
    protected $table = 'carts';

    public function cartItems()
    {
    	return $this->hasMany('App\Models\CartItem','cart_id', 'id');
    }

    public function cartItemsTotal($cart_id)
     {
     	$cart_total =CartItem::where('cart_id',$cart_id)->sum('price');
     	return $cart_total;
     }
}



