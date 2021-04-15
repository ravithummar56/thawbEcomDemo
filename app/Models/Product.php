<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class Product extends BaseModel
{
    protected $table = 'products';

    public function productImages()
	{
		 return $this->hasMany('App\Models\ProductImage','product_id','id');
	}

	public function productColor()
	{
		 return $this->hasMany('App\Models\ProductColor','product_id','id');
	}

	public function productSize()
	{
		 return $this->hasMany('App\Models\ProductSize','product_id','id');
	}

	public function productFabric()
	{
		 return $this->hasMany('App\Models\ProductFabric','product_id','id');
	}

	public function productTranslation()
	{
		return $this->hasMany('App\Models\ProductTranslation','product_id','id');
	}

	
	public function productTranslationWithLang()
	{	
		 return $this->belongsTo('App\Models\ProductTranslation', 'id','product_id')->where('lang_id',Config('app.locale'));
	}

	public function productFabricValue()
	{
		 return $this->belongsToMany(Fabric::class, 'product_fabrics','product_id','fabric_id');
	}

	public function productColorValue()
	{
		 return $this->belongsToMany(Color::class, 'product_fabrics','product_id','fabric_id');
	}

	public function productSizeValue()
	{
		 return $this->belongsToMany(Size::class, 'product_fabrics','product_id','fabric_id');
	}
}



