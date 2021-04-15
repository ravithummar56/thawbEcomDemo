<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class ProductImage extends BaseModel
{
    protected $table = 'product_images';

    protected $appends = array('image_path');

    public function getImagePathAttribute()
    {
        return $this->image != null ? Url("/public".config('admin.image.product').$this->product_id.'/'.$this->image) : Url('public/default/default_user.png');  
    }
}



