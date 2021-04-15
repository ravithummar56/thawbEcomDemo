<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Base\Api\ApiController;
use Hash;
use Validator;
use Exception;
use Log;

class CartController extends ApiController

{
    public function getCart(Request $request)
    {
        try {
            $user = getSessionBySession(request('session_id'));
            if($user == null){
                $user_id = request('session_id');
            }else{
                $user_id = $user;
            }
            
            $cart = $this->Cart->where('user_id',$user_id)->first();
            if(!$cart){
                return $this->sendResponse('fail', trans('api.empty_cart'));
            }else{
                $cart_items = $cart->cartItems;
                foreach($cart_items as $product)
                {
                    if($product['product_type'] == 'product'){
                         $product->productDetails;
                        $product->productDetails->productTranslationWithLang;
                        $product->productDetails->productImages;
                        $product->colorDetails;
                        $product->fabricDetails;
                        $product->sizeDetails;
                        $product->kandoraStyleDetails;
                    }else{
                        $product->makeProductDetails;
                        $product->makeProductDetails->fabricDetails;
                        $product->makeProductDetails->colorDetails;
                        $product->makeProductDetails->sizeDetails;
                        $product->makeProductDetails->collarStyleDetails;
                        $product->makeProductDetails->kandoraStyleDetails;
                    }
                }
            
            $cart_details['cart'] = $cart;
            $cart_details['shipping_charg'] = $this->ShippingCharg->first();
            }
            return $this->sendResponse($cart_details, trans('api.get_cart'));
            
        } catch (Exception $e) {
            
             return $this->debugLog('#APIs '.$e->getMessage());

        }
    }

    public function addToCart(Request $request)
    {
        try {

            $data = request()->all();
            $quantity = $data['qty'];
            $old_price = 0;
            $size =  request('size_id',""); 
            $color = request('color_id',"");
            $fabric = request('fabric_id',"");
            $kandora_style = request('kandora_style_id',"");

            $user = getSessionBySession(request('session_id'));

            if($user == null){
                $user_id = $data['session_id'];
            }else{
                $user_id = $user;
            }
            if($data['product_type'] == 'product'){
                $product_details = $this->Product->where('id',$data['product_id'])->where('status','active')->first();
                if($product_details){

                    if($product_details->quantity == 0){

                        return $this->sendResponse('fail', $product_details->product_name.' Out Of Stock.');
                    }
                    if($product_details->quantity < $data['qty']){

                        return $this->sendResponse('fail','Only '. $product_details->quantity.' Quantity Available.');      
                    }
                }else{
                    return $this->sendResponse('fail', 'Product Not Available');
                }
            }

            if($data['product_type'] == 'make_product'){

                $product = $this->MakeProducts->where('id',$data['product_id'])->first();
                if(!$product){
                    return $this->sendResponse('fail', 'Product Not Available');
                }else{
                    $product_details = [
                        'id' => $product->id,
                        'sell_price' => $product->price,
                    ];
                }
            }

            $get_cart = $this->Cart->where('user_id',$user_id)->first();
            if($get_cart){
                $get_cartitems =$this->CartItem->where('cart_id',$get_cart->id)->where('product_id',$data['product_id'])->where('size_id',$size)->where('color_id',$color)->first(); 

                if($get_cartitems){
                        $old_price =  $get_cartitems->price ;
                        $quantity =  $data['qty'] + $get_cartitems->quantity ;
                   
                }
            }
            $product_unit_total = $product_details['sell_price'] * $quantity;
            $subtotal_data = 0;
            if($get_cart){
                $subtotal_data = $get_cart->subtotal;
            }

            $subtotal = $subtotal_data + $product_unit_total - $old_price ;

            $total = $subtotal;

            $cart = $this->Cart->updateOrCreate(
                ['user_id' => $user_id ],
                ['subtotal' => $subtotal ,
                'total' => $total,  
                'user_id' => $user_id ]);

            $cart['cart_items'] = $this->CartItem->updateOrCreate([
                'cart_id' => $cart->id,
                'product_id' => $product_details['id'],
                'size_id' => $size,
                'color_id' => $color ],
                ['cart_id' => $cart->id ,
                'product_id' => $product_details['id'] , 
                'product_type' => $data['product_type'] , 
                'quantity' => (int) $quantity,
                'price' =>  $product_unit_total ,
                'size_id' => (int) $size,
                'kandora_style_id' => (int) $kandora_style,
                'fabric_id' => (int) $fabric,
                'color_id' => (int) $color]);

            if ($data['product_type'] == 'product') {

            $product_details->update(['quantity' => $product_details['quantity'] - $data['qty']] );  
            }

            return $this->sendResponse($cart, trans('api.add_cart'));
        } catch (Exception $e) {

            return $this->debugLog('#APIs '.$e->getMessage());
            
        }
    }

    public function updateCart(Request $request)
    {
        try
        {
        
            $data = request()->all();
            // $cart_items = $this->CartItem->where('cart_id',$data['cart_id'])->where('product_id',$data['product_id'])->where(['size_id'=>$data['size_id'],'fabric_id'=>$data['fabric_id'],'color_id'=>$data['color_id']])->first();
            // if(!$cart_items){
            //     return $this->sendResponse('fail', trans('api.product_not'));
            // }
            // $cart = $cart_items->cart;
            // if($cart_items->product_type == 'product'){

            //     $product_details = $cart_items->productDetails;
            //     if($data['qty'] != 0){
            //         if($data['qty_status'] == 'add'){

            //             $upadte_cart_item_qty = $cart_items->quantity + $data['qty']; 
            //             /*two opption for upadte cart send total qunty otherwise send increment or decrement qty*/

            //             $product_unit = $upadte_cart_item_qty * $product_details->sell_price ;

            //             $cart_items->update(['price' =>  $product_unit ,'quantity' => $upadte_cart_item_qty]);
            //             $product_details->update(['quantity' => $product_details->quantity - $data['qty']] );
            //         }else{
            //             $upadte_cart_item_qty = $cart_items->quantity - $data['qty']; 
            //             /*two opption for upadte cart send total qunty otherwise send increment or decrement qty*/
            //             if($upadte_cart_item_qty == 0){
            //                 $cart_items->delete();
                            
            //             }else{

            //                 $product_unit = $upadte_cart_item_qty * $product_details->sell_price ;

            //                 $cart_items->update(['price' =>  $product_unit ,'quantity' => $upadte_cart_item_qty]);
            //                 $product_details->update(['quantity' => $product_details->quantity + $data['qty']] );
            //            }

            //         }

                      
            //     }else{
            //         $product_details->update(['quantity' => $product_details->quantity +  $cart_items->quantity] ); 
                    
            //         $cart_items->delete();
            //     }
            // }
            // else{
            //     if($data['qty'] != 0){
            //         $custome_product  = $this->MakeProducts->where('id',$cart_items->product_id)->first(); 
            //         if($data['qty_status'] == 'add'){

            //             $upadte_cart_item_qty = $cart_items->quantity + $data['qty']; 
            //             // two opption for upadte cart send total qunty otherwise send increment or decrement qty

            //             $product_unit = $upadte_cart_item_qty * $custome_product->price ;

            //             $cart_items->update(['price' =>  $product_unit ,'quantity' => $upadte_cart_item_qty]);
                       
            //         }else{
            //             $upadte_cart_item_qty = $cart_items->quantity - $data['qty']; 
            //             /*two opption for upadte cart send total qunty otherwise send increment or decrement qty*/
            //             if($upadte_cart_item_qty == 0){
            //                 $cart_items->delete();
            //             }else{
            //                 $product_unit = $upadte_cart_item_qty * $custome_product->price ;
            //                 $cart_items->update(['price' =>  $product_unit ,'quantity' => $upadte_cart_item_qty]);    
            //            }
            //         } 
            //     }else{ 
            //         $cart_items->delete();
            //     }
            // }
            // $cart_items = $this->CartItem->where('cart_id',$data['cart_id'])->first();
                        
            // if(!$cart_items){
            //     $cart->delete();
            // return $this->sendResponse('fail', trans('api.update_cart'));  
            // } 


            // $subtotal = $cart->cartItemsTotal($cart->id);

            // $total = $subtotal ; 

            // $cart->update(['subtotal' => $subtotal ,'total' => $total]);

            // $cart_items = $cart->cartItems;
            //     foreach($cart_items as $product)
            //     {
            //         if($product['product_type'] == 'product'){
            //              $product->productDetails;
            //             $product->productDetails->productTranslationWithLang;
            //             $product->productDetails->productImages;
            //             $product->colorDetails;
            //             $product->fabricDetails;
            //             $product->sizeDetails;
            //             $product->kandoraStyleDetails;
            //         }else{
            //             $product->makeProductDetails;
            //             $product->makeProductDetails->fabricDetails;
            //             $product->makeProductDetails->colorDetails;
            //             $product->makeProductDetails->sizeDetails;
            //             $product->makeProductDetails->collarStyleDetails;
            //             $product->makeProductDetails->kandoraStyleDetails;
            //         }
            //     }
            
            // $update_cart['cart'] = $cart;

                $cart_items = $this->CartItem->where('id',$data['cart_item_id'])->first();
                if(!$cart_items){
                    return $this->sendResponse('fail', trans('api.product_not'));
                }
                
                $product_price = $cart_items->price;
                $cart_items->delete();
                $cart  = $this->Cart->withCount('cartItems')->where('id',$data['cart_id'])->first();
                if($cart){
                    if($cart->cart_items_count == 0){
                        $cart->delete();
                        return $this->sendResponse('fail', trans('api.empty_cart'));
                    }
                    $cart->update(['subtotal'=>$cart->subtotal-$product_price,'total'=>$cart->total-$product_price]);
                }
                $cart  = $this->Cart->where('id',$data['cart_id'])->first();
            return $this->sendResponse($cart, trans('api.update_cart'));
        }
        catch(Exception $e)
        {   
            return $this->debugLog('#APIs '.$e->getMessage());
        }  
    } 

    public function makeProduct(Request $request)
    {

        $rule = [
            'user_sizes_id'=>'required', 
            'color_id'=>'required', 
            'fabric_id'=>'required',  
            'kandora_style_id'=>'required', 
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails())
        {
             return $this->sendError('Validation Error.', ['error'=>$validate->errors()]);     
        }
        try {
            $data = request()->all();
            $size = $this->UserSizes->where('id',$data['user_sizes_id'])->first();
            if(!$size){
            return $this->sendResponse(0, 'User Sizes are not Available');    
            }
            $user = getSessionBySession(request('session_id'));
            $user_id = $user;
            unset($data['session_id']);
            $data['user_id'] = $user_id;
            $user_size = $this->UserSizes->where('id',$data['user_sizes_id'])->first();
            if(!$user_size){
                return $this->sendResponse('0', 'Size Not Found.'); 
            }
            $size_kandora = $user_size->length;
            $dimension_type= $user_size->dimension_type;
            if($dimension_type =='cm'){
                if($size_kandora >= '160cm'){
                    $price = $this->KandoraPrice->where('title','160cm<')->first();
                }else{
                    $price = $this->KandoraPrice->where('title','160cm>')->first();
                }
            }else{
                if($size_kandora >= '64in'){
                    $price = $this->KandoraPrice->where('title','64in<')->first();
                }else{
                    $price = $this->KandoraPrice->where('title','64in>')->first();
                }
            }
            $data['price'] = $price->price;
            $product = $this->MakeProducts->create($data);
            return $this->sendResponse($product, trans('api.make_product'));
            
        } catch (Exception $e) {
            return $this->debugLog('#APIs '.$e->getMessage());
        }
    }
}
