<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class Fabric extends BaseModel
{
    protected $table = 'fabrics';

    protected $appends = array('image_path');

	public function getImagePathAttribute()
    {
        return $this->image != null ? Url("/public".config('admin.image.fabric').$this->image) : Url('public/default/default_user.png');  
    }
}



