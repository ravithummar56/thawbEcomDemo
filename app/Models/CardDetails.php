<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class CardDetails extends BaseModel
{
    protected $table = 'card_details';

    protected $appends = array('image_path');

    public function getImagePathAttribute()
    {
        return $this->card_name != null ? Url("/public/upload/card/".$this->card_name.'.png') : Url('/public/upload/card/invalid.png');  
    }
}



