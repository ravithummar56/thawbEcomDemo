<?php 

use App\Models\User;
use App\Models\PaymentStatus;
use App\Models\OrderStatus;
use App\Models\UserSession;
use App\Models\UserSizes;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MakeProducts;

if (!function_exists('admin')) 
{   
    function admin()
    {
        return 'admin';
    }
}

function users()
{
    // $users = User::selectRaw('id, CONCAT(first_name," ",last_name) as name')->pluck('name','id');
    $users = User::pluck('username','id');
   return $users;   
}

function paymentStatus($id)
{
    $payment_status = PaymentStatus::where('id',$id)->first();

    return trans('status.'.$payment_status->status_value);
}

function orderStatus($id)
{
    $order_status = OrderStatus::where('id',$id)->first();

    return trans('status.'.$order_status->status_value);
}

function getSessionBySession($sessionId)
{
    $session = UserSession::where('session_id',$sessionId)->first();
    if($session !=null ){
        $user = $session->userDetails;
        return $user ? $user->id : $session->user_id;
    }
    $user = null;
    return $user;
}

// function updateCartSizeProduct($session_id,$user_id)
// {   
//     UserSizes::where('user_id',$user_id)->delete();
//     UserSizes::where('user_id',$session_id)->update(['user_id'=>$user_id]);
//     Cart::where('user_id',$user_id)->delete();
//     Cart::where('user_id',$session_id)->update(['user_id'=>$user_id]);
//     MakeProducts::where('user_id',$session_id)->update(['user_id'=>$user_id]);
// }

function updateCartSizeProduct($session_id,$user_id)
{   
    
    $old_cart = Cart::where('user_id',$user_id)->first();
    $new_cart = Cart::where('user_id',$session_id)->first();
    if($new_cart){
        if($old_cart){

            $old_items = CartItem::where('cart_id',$old_cart->id)->update(['cart_id'=>$new_cart->id]);
            $new_cart->update(['subtotal'=>$new_cart->subtotal+$old_cart->subtotal ,'total'=>$new_cart->total+$old_cart->total,'user_id'=>$user_id]);
            $old_cart->delete();
        }else{
            $new_cart->update(['user_id'=>$user_id]);
        }
    }

    $old_size_id = null;
    $old_size = UserSizes::where('user_id',$user_id)->first();
    $new_size = UserSizes::where('user_id',$session_id)->first();
    if($new_size){
        if($old_size){
            $old_size_id = $old_size['id'];
            unset($new_size['id'],$new_size['user_id']);
            $old_size->update($new_size); 
        }else{
            $new_size->update(['user_id'=>$user_id]);
        }
    }

    if($old_size_id){
        MakeProducts::where('user_id',$session_id)->update(['user_id'=>$user_id,'user_sizes_id'=>$old_size_id]);
    }else{
        MakeProducts::where('user_id',$session_id)->update(['user_id'=>$user_id]);
    }
}

