<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class UserSession extends BaseModel
{
    protected $table = 'user_session';

    public function userDetails()
    {
    	return $this->belongsTo('App\Models\User','user_id');
    }
}



