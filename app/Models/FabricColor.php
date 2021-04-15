<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class FabricColor extends BaseModel
{
    protected $table = 'fabric_colors';
    
    public function getFabric()
    {
    	return $this->belongsTo('App\Models\Fabric','fabric_id');
    }
}
