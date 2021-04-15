<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class CollarSleeveStyle extends BaseModel
{
    protected $table = 'collar_sleeve_styles';

    protected $appends = array('image_path');

	public function getImagePathAttribute()
    {
        return $this->image != null ? Url("/public".config('admin.image.collar_style').$this->image) : Url('public/default/default_user.png');  
    }

    public function kandoraStyle()
    {
    	return $this->belongsTo('App\Models\KandoraStyle','kandora_style_id');
    }
}
