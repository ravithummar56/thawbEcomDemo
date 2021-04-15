<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	protected $guarded = ['id'];

}