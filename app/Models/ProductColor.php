<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class ProductColor extends BaseModel
{
    protected $table = 'product_colors';

    public function productColorValue()
	{
		 return $this->hasMany('App\Models\Fabric','id','fabric_id');
	}

}



