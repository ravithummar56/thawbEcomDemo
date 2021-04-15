<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class ProductFabric extends BaseModel
{
    protected $table = 'product_fabrics';

    public function productFabricValue()
	{
		 return $this->belondTo('App\Models\Fabric','fabric_id','id');
	}
    
}



