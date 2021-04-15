<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Base\Api\ApiController;
use Hash;
use Validator;
use Exception;
use Log;
use App\Models\OrderItems;
use App\Models\ProductTranslation;
use App\Models\OrderedProduct;
use App\Models\ProductImage;
use DB;

class OrderController extends ApiController

{
    public function checkout(Request $request)
   	{
   		DB::beginTransaction();
   		try
		{
		
			$data = request()->all();
	   		$user = getSessionBySession(request('session_id'));
	   		$cart = $this->Cart->where('user_id',$user)->first();
	   		if(!$cart){
	   			return $this->sendResponse('1', trans('api.empty_cart'));
	   		}

	   		if($data['promo_code']){
	   			$code_condition = $this->PromotionCode->count->where('code',$data['promo_code'])->where('start_date','<=',date('Y-m-d'))->first();
	   			$order = $this->Order->where('promo_code',$data['promo_code'])->count();
	   			if($code_condition){
	   				if($code_condition->end_date < date('Y-m-d')){
	   					return $this->sendResponse('1', trans('api.cod_exp'));
	   				}

	   				if($code_condition->limit == $order){
	   					return $this->sendResponse('1', trans('api.code_used'));
	   				}

	   			}else{
	   				return $this->sendResponse('1', trans('api.wrong_code'));
	   			}
	   			
	   		}
	   		$shipping_charge = '0';

	   		$user_address = $this->CustomerAddress->where('id',$data['shipping_address'])->first();
	   		if($user_address){
	   			$shipping_charge = '10';
	   		}

	   		$user = $this->User->where('id',$user)->first();
	   		$new_order = $this->Order;
			$new_order->user_id =$user->id;
			$new_order->order_id = 'dsfs';
			$new_order->order_name = $user->first_name.' '.$user->last_name;
			$new_order->order_email = $user->email;
			$new_order->order_phone_number = $user->phone_number;
			$new_order->billing_address_id = $data['billing_address'];
			$new_order->shipping_address_id = $data['shipping_address'] ;
			$new_order->order_status_id = 1;
			$new_order->promo_code = $data['promo_code'];
			$new_order->payments_type = $data['payment_method'];
			$new_order->payments_status_id = $data['payment_status_id'];
			$new_order->invoice_number = 'ID'.uniqid();
			$new_order->subTotal = $cart->subtotal;
			$new_order->shipping_charge = $shipping_charge;
			$new_order->total = $cart->total + $shipping_charge;
			$new_order->orderDate =date('Y/m/d');
			$new_order->extra_note =$data['extra_note'];
			$new_order->tag_name =$data['tag_name'];						
			$new_order->save();

			if($new_order->save()){
				$new_order->order_id = 'ORD'. $new_order->id;	
				$new_order->save();
			}
			$order_details['order_items'] = [];
			//create the order items and remove the cartitems.
			foreach($cart->cartItems as $item) 
			{
				$order_items = new OrderItems;
				$order_items->order_id = $new_order->id;
				$order_items->product_id = $item->product_id;

				if ($item->product_type == 'product') {
					$product_translation = ProductTranslation::where('product_id',$item->product_id)->select('product_id','product_name','lang_id')->get()->toArray();
					OrderedProduct::insert($product_translation);
					$order_items->fabric_id = $item->fabric_id;
					$order_items->color_id = $item->color_id;
					$order_items->size_id = $item->size_id;
					$order_items->product_slug = $item->productDetails->slug;
					$order_items->fabric_name = $item->fabricDetails['fabric_name'];
					$order_items->color_name = $item->colorDetails['color_name'];
					$order_items->size_name = $item->sizeDetails['size_name'];
					$order_items->kandora_style = $item->kandoraStyleDetails['name'];
					$order_items->kandora_style_id = $item->kandora_style_id;
					$order_items->gender = $item->productDetails->gender;
					$order_items->type = $item->productDetails->type;
					$order_items->manufacturing_price = $item->productDetails->manufacturing_price;
					$order_items->price = $item->productDetails->price;
					$order_items->sell_price = $item->productDetails->sell_price;
					$order_items->product_type = $item->productDetails->product_type;
					$order_items->quantity = $item->quantity ;
					$order_items->total = $item->price;

				}else{
					$user_size = $this->UserSizes->where('user_id',$user->id)->first()->toArray();
					$user_size['user_id'] = $user->id;
					$user_size['order_id'] = $new_order->id;
					$order_items->fabric_id = $item->makeProductDetails->fabric_id;
					$order_items->color_id = $item->makeProductDetails->color_id;
					$order_items->user_size_id = $item->makeProductDetails->user_sizes_id;
					$order_items->product_slug = 'custome-product';
					$order_items->fabric_name = $item->makeProductDetails->fabricDetails->fabric_name;
					$order_items->color_name = $item->makeProductDetails->colorDetails->color_name;
					$order_items->collar_style = $item->makeProductDetails->collarStyleDetails->title;
					$order_items->kandora_style = $item->makeProductDetails->kandoraStyleDetails->title;
					$order_items->collar_style_id = $item->makeProductDetails->collar_style_id;
					$order_items->kandora_style_id = $item->makeProductDetails->kandora_style_id;
					$order_items->gender = $item->makeProductDetails->gender;
					$order_items->sleeve_style = $item->makeProductDetails->sleeve_style;
					$order_items->manufacturing_price = $item->makeProductDetails->price;
					$order_items->price = $item->makeProductDetails->price;
					$order_items->sell_price = $item->makeProductDetails->price;
					$order_items->product_type = 'custome_product';
					$order_items->quantity = $data['promo_code'] ? $item->quantity + 1 : $item->quantity ;
					$order_items->total = $item->price;
				}
					$order_items->save();
					if($item->product_type == 'make_product'){
						$user_size['order_item_id'] = $order_items->id;
						$this->OrderUserSizes->create($user_size);
					}
					$order_details['order_items'][] =$order_items; 
					$item->delete();
			}
			$cart->delete();
			$order_details['status'] = 1;
			$order_details['order'] = $new_order;
			DB::commit();
	    	return $this->sendResponse($order_details, trans('api.order'));
	    }
		catch (\Exception $e) {
			DB::rollBack();
			return $this->debugLog('#APIs '.$e->getMessage());
		}	
   	}

   	public function myOrder($id)
   	{
   	 	try {
   	 		$myOrder = $this->Order->with('billAddress','paymentStatus','orderStatus','shipaddress')->where('id',$id)->first();
   	 		foreach ($myOrder->orderItems as $order) {
   	 				if($order->product_type == 'custome_product'){
   	 					$image_Path = Url('public/default/default_user.png');
   	 				}else{
   	 					$image_Path = ProductImage::where('product_id',$order->product_id)->first();
   	 					$image_Path = $image_Path->image != null ? Url("/public".config('admin.image.product').$image_Path->product_id.'/'.$image_Path->image) : Url('public/default/default_user.png');
   	 				}
   	 				$order->item_image_path = $image_Path;
                    $order->fabricDetails;
                    $order->colorDetails;
                    $order->kandoraStyleDetails;
                    $order->productDetails;
                    $order->sizeDetails;
   	 			if($order->product_type == 'custome_product'){
                    $order->collarStyleDetails;
                }
   	 			
   	 		}
   	 		
   	 		return $this->sendResponse($myOrder, trans('api.all_order'));
   	 		
   	 	} catch (Exception $e) {

   	 		return $this->debugLog('#APIs '. $e->getMessage());
   	 	}
   	}

   	public function myOrders(Request $request)
   	{
   		try {
   			$user = getSessionBySession(request('session_id'));
   			$myOrders = $this->Order->with('billAddress','paymentStatus','orderStatus','shipaddress')->where('user_id',$user)->paginate(10);
   			foreach ($myOrders as $myOrder) {
	   			foreach ($myOrder->orderItems as $order) {
	   	 				if($order->product_type == 'custome_product'){
	   	 					$image_Path = Url('public/default/default_user.png');
	   	 				}else{
	   	 					$image_Path = ProductImage::where('product_id',$order->product_id)->first();
	   	 					$image_Path = $image_Path->image != null ? Url("/public".config('admin.image.product').$image_Path->product_id.'/'.$image_Path->image) : Url('public/default/default_user.png');
	   	 				}
	   	 				$order->item_image_path = $image_Path;
	                    $order->fabricDetails;
	                    $order->colorDetails;
	                    $order->kandoraStyleDetails;
	                    $order->productDetails;
	                    $order->sizeDetails;
	   	 			if($order->product_type == 'custome_product'){
	                    $order->collarStyleDetails;
	                    ;
	                }
	   	 			
	   	 		}
   			}
   			return $this->sendResponse($myOrders, trans('api.all_order'));
   		} catch (Exception $e) {
   			return $this->debugLog('#APIs '. $e->getMessage());
   		}
   	}
}
