<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class MakeProducts extends BaseModel
{
    protected $table = 'make_products';

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
    	return $this->belongsTo('App\Models\UserSizes','user_sizes_id','id');
    }

    public function collarStyleDetails()
    {
        return $this->belongsTo('App\Models\CollarSleeveStyle','collar_style_id','id');
    }

    public function kandoraStyleDetails()
    {
        return $this->belongsTo('App\Models\KandoraStyle','kandora_style_id','id');
    }
}
