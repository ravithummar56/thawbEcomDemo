<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class OrderItems extends BaseModel
{
    protected $table = 'order_items';

    public function productImagesSingel()
	{
		 return $this->belongsTo('App\Models\ProductImage','product_id','product_id');
	}

	public function productDetails()
	{
		if($this->product_type == 'custome_product'){
			return $this->belongsTo('App\Models\MakeProducts','product_id','id');
		}else{
		 	return $this->belongsTo('App\Models\OrderedProduct','product_id','product_id')->where('lang_id',config('app.locale'));
		}
	}
    public function sizeDetails()
    {
    	if($this->product_type == 'custome_product'){
    		return $this->belongsTo('App\Models\OrderUserSizes','id','order_item_id');
    	}else{
    		return $this->belongsTo('App\Models\Size','size_id');
    	}
    }

    public function fabricDetails()
    {
    	return $this->belongsTo('App\Models\Fabric','fabric_id','id');
    }

    public function colorDetails()
    {
    	return $this->belongsTo('App\Models\Color','color_id','id');
    }
	
	public function kandoraStyleDetails()
    {
        return $this->belongsTo('App\Models\KandoraStyle','kandora_style_id','id');
    }

    public function collarStyleDetails()
    {
        return $this->belongsTo('App\Models\CollarSleeveStyle','collar_style_id','id');
    }
}



