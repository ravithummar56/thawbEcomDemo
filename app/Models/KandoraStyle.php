<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class KandoraStyle extends BaseModel
{
    protected $table = 'kandora_styles';

    protected $appends = array('image_path');

    public function getImagePathAttribute()
    {
        return $this->image != null ? Url("/public".config('admin.image.kandora_style').$this->image) : Url('public/default/default_user.png');  
    }
}
