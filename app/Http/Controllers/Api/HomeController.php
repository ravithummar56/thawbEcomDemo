<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Base\Api\ApiController;
use Hash;
use Validator;
use Exception;
use Log;
use Config;

class HomeController extends ApiController

{    
    public function getColor(Request $request)
    {
    	try {
    		
	    	$gender = request('gender');
	    	$getColor = $this->Color->where($gender,'yes')->where('status','active')->get();

	    	return $this->sendResponse($getColor, trans('api.get_color'));

    	} catch (Exception $e) {

    		return $this->debugLog('#APIs '.$e->getMessage());
    	}
    }

    public function getFabric(Request $request)
    {
    	try {
            $gender = request('gender');
	    	$color_id = request('color_id');
	    	$fabrics = $this->FabricColor->with('getFabric')->whereHas('getFabric',function ($q) use($gender)
            {
                $q->where($gender,'yes');
            })->where('color_id',$color_id)->get();
	    	return $this->sendResponse($fabrics,trans('api.get_fabric'));

		} catch (Exception $e) {

    		return $this->debugLog('#APIs '.$e->getMessage());
    	}
    }

    public function getProduct(Request $request)
    {
    	try {
        	$products = $this->Product->with('productTranslationWithLang','productImages','productSizeValue','productColorValue','productFabricValue');
            if(request('product_type')== 'finish_product'){
               $products = $products->where('product_type','finish_product');
            }
            $products = $products->where('status','active')->paginate(10);
    		return $this->sendResponse($products, trans('api.get_product'));
		
		} catch (Exception $e) {

    		return $this->debugLog('#APIs '.$e->getMessage());
    	}
    }

    public function getCard(Request $request)
    {
    	try {

    		$user_card = $this->CardDetails->where('user_id',request('user_id'))->get();
    		
    		return $this->sendResponse($user_card, trans('api.get_card'));

		} catch (Exception $e) {

    		return $this->debugLog('#APIs '.$e->getMessage());

    	}
    	
    }

    public function saveCard(Request $request)
    {
    	try {
    		$data = request()->all();
    		$user = getSessionBySession($data['session_id']);
    		unset($data['session_id']);
    		$data['user_id'] = $user;
    		$card_details = $this->CardDetails;
    		$card_details->fill($data);
    		$card_details->save();
    		return $this->sendResponse($card_details, trans('api.save_card'));
    		
    	} catch (Exception $e) {
    		
    		return $this->debugLog('#APIs '.$e->getMessage());
    	}
    }

    public function editCard($id)
    {
        try {
            $editCard = $this->CardDetails->find($id);
            if($editCard){

            return $this->sendResponse($editCard, trans('api.edit_card'));
            }
            return $this->sendResponse(null, trans('api.no_found'));
            
        } catch (Exception $e) {

            return $this->debugLog('#APIs '. $e->getMessage());
        }
    }

    public function updateCard(Request $request,$id)
    {
        try {
            $data = request()->all();
            unset($data['session_id']);

            $updateCard = $this->CardDetails->where('id',$id)->update($data);
            return $this->sendResponse(1, trans('api.update_card'));
            
        } catch (Exception $e) {
            return $this->debugLog('#APIs '. $e->getMessage());
        }
    }

    public function deleteCard($id)
    {
        try {
            $deleteCard = $this->CardDetails->where('id',$id)->delete();
            return $this->sendResponse($deleteCard, trans('api.delete_card'));
            
        } catch (Exception $e) {

            return $this->debugLog('#APIs '. $e->getMessage());
        }
    }

    public function getAddress(Request $request)
    {
        try {

            $user_address = $this->CustomerAddress->where('user_id',request('user_id'))->where('action','active')->get();
            return $this->sendResponse($user_address, trans('api.get_customer_address'));

        } catch (Exception $e) {
            
            return $this->debugLog('#APIs '.$e->getMessage());

        }
        
    }

    public function saveAddress(Request $request)
    {
    	try {
    		
    		$data = request()->all();
    		$user = getSessionBySession($data['session_id']);
    		unset($data['session_id']);
    		$data['user_id'] = $user;
            if($data['default'] == 'yes'){
                $this->CustomerAddress->where('user_id',$data['user_id'])->update(['default'=>'no']);
            }
    		$customer_details = $this->CustomerAddress;
    		$customer_details->fill($data);
    		$customer_details->save();

    		return $this->sendResponse($customer_details, trans('api.save_address'));
    		
    	} catch (Exception $e) {
    		return $this->debugLog('#APIs '.$e->getMessage());
    	}
    }

    public function editAddress($id)
    {
        try {
            $getAddress = $this->CustomerAddress->find($id);
            if($getAddress){

            return $this->sendResponse($getAddress, trans('api.edit_address'));
            
            }
            return $this->sendResponse(null, trans('api.no_found'));
            
        } catch (Exception $e) {

            return $this->debugLog('#APIs '. $e->getMessage());
        }
    }

    public function updateAddress(Request $request,$id)
    {
        try {
            $data = request()->all();
            $user = getSessionBySession($data['session_id']);
            unset($data['session_id']);
            $data['user_id'] = $user;
            if($data['default'] == 'yes'){
                $this->CustomerAddress->where('user_id',$data['user_id'])->update(['default'=>'no']);
            }
            $updateAddress = $this->CustomerAddress->where('id',$id)->update($data);
            return $this->sendResponse($updateAddress, trans('api.update_address'));
            
        } catch (Exception $e) {

            return $this->debugLog('#APIs '. $e->getMessage());
        }
    }

    public function deleteAddress($id)
    {
        $deleteAddress = $this->CustomerAddress->where('id',$id)->update(['action'=>'deactive']);
        return $this->sendResponse($deleteAddress, trans('api.delete_address'));
    }

    public function getUserSizes(Request $request)
    {
        try {

            $data = request()->all();
            $user = getSessionBySession($data['session_id']);
            unset($data['session_id']);
            $data['user_id'] = $user;
            $user_sizes = $this->UserSizes->where('user_id',$data['user_id'])->get();

            return $this->sendResponse($user_sizes, trans('api.get_sizes'));
            
        } catch (Exception $e) {
            
            return $this->debugLog('#APIs '. $e->getMessage());
        }
    }

    public function storeUserSizes(Request $request)
    {
        try {

            $data = request()->all();
            $user = getSessionBySession($data['session_id']);
            unset($data['session_id']);
            $data['user_id'] = $user;
            unset($data['id']);
            $user_sizes = $this->UserSizes->updateOrCreate(
                ['user_id'=>$user
                ],
                [
                'user_id'=>$data['user_id'],
                'sleeves'=>$data['sleeves'],
                'bust'=>$data['bust'],
                'hips'=>$data['hips'],
                'length'=>$data['length'],
                'lower_sleeve'=>$data['lower_sleeve'],
                'neck'=>$data['neck'],
                'shoulder_width'=>$data['shoulder_width'],
                'comment'=>$data['comment'],
                'dimension_type'=>$data['dimension_type'],
                ]);

            return $this->sendResponse($user_sizes, trans('api.save_sizes'));
            
        } catch (Exception $e) {
            
            return $this->debugLog('#APIs '. $e->getMessage());
        }
    }

    public function getKandoraStyle()
    {
        try {
            $allKandoraStyle = $this->KandoraStyle->get();
             return $this->sendResponse($allKandoraStyle, trans('api.get_kandora'));
        } catch (Exception $e) {
            return $this->debugLog('#APIs '. $e->getMessage());
        }
    }

    public function getCollerSleeveStyle()
    {
        try {
            $kandora_style_id = request('kandora_style_id');
            $allCollerStyle = $this->CollarSleeveStyle->where('kandora_style_id',$kandora_style_id)->get();
             return $this->sendResponse($allCollerStyle, trans('api.get_coller'));
        } catch (Exception $e) {
            return $this->debugLog('#APIs '. $e->getMessage());
        }
    }

    public function requestTailor(Request $request)
    {
        try {
            $data = request()->all();
            if($data['code']){
                $check_code = $this->RequestTrailer->where('code',$data['code'])->first();
                if($check_code){
                    return $this->sendResponse('1', trans('api.alredy_code_use'));
                }
            }
            unset($data['session_id']);
            $request = $this->RequestTrailer;
            $request->fill($data);
            $request->save();

            return $this->sendResponse($request, trans('api.save_request'));
            
        } catch (Exception $e) {
            return $this->debugLog('#APIs '. $e->getMessage());
        }
    }


}
