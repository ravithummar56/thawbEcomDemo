<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class CartItem extends BaseModel
{
    protected $table = 'cart_items';

    public function productDetails()
    {
    	return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function fabricDetails()
    {
    	return $this->belongsTo('App\Models\Fabric','fabric_id','id');
    }

    public function colorDetails()
    {
    	return $this->belongsTo('App\Models\Color','color_id','id');
    }

    public function sizeDetails()
    {
    	return $this->belongsTo('App\Models\Size','size_id','id');
    }
        
    public function cart() 
    {
        return $this->belongsTo('App\Models\Cart','cart_id');
    }

    public function kandoraStyleDetails()
    {
        return $this->belongsTo('App\Models\KandoraStyle','kandora_style_id','id');
    }

    public function makeProductDetails()
    {
        return $this->belongsTo('App\Models\MakeProducts','product_id','id');
    }
}



