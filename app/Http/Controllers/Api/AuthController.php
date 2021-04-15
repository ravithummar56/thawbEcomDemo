<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Base\Api\ApiController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Hash;
use Validator;
use Exception;
use Log;


class AuthController extends ApiController
{
	use SendsPasswordResetEmails;

	public function loginDevice(Request $request)
	{
		try {

			$data = request()->all();
			$session = $this->UserSession->updateOrCreate(
	                ['user_id' => $data['device_id']],
	                ['user_id' => $data['device_id'] ,
	                'session_id' => uniqid(),
	            	'login'=>'no']);
					return $this->sendResponse($session, trans('api.login'));
			
		} catch (Exception $e) {
			
		}
	}

   public function login(Request $request)
   {
   		$rule = [
            'phone_number' => 'required',
            'password' => 'required',  
        ];
        $msg = [
        	'phone_number.required' => trans('user.phone_number_required'),
            'password.required' => trans('user.password_required'),
        ];

        $validate = Validator::make($request->all(), $rule,$msg);

        if ($validate->fails())
        {
             return $this->sendError('Validation Error.', ['errors' => $validate->errors()]);     
        }   
	   	try
		{
			$data = request()->all();
			$user = $this->User->where('phone_number',$data['phone_number'])->where('role_id','2')->first();

			if($user){
				// if($user->phone_verify == 'false'){
				// 	return $this->sendResponse('fail', trans('api.verify_phone'));	
				// }
				if(Hash::check($data['password'], $user->password)){
					$this->User->update(['device_id'=>$data['device_id'],'device_type'=>$data['device_type']]);
					$this->UserSession->where('user_id',$user->id)->delete();

					$session = $this->UserSession->updateOrCreate(
	                ['user_id' => $data['device_id']],
	                ['user_id' => $user->id ,
	                'session_id' => uniqid(),
	            	'login'=>'yes']);
	            	if($data['session_id']){
	            		updateCartSizeProduct($data['device_id'],$user->id);
	            	}
	            	
					return $this->sendResponse($session, trans('api.login'));
				}else{
					return $this->sendResponse('fail', trans('api.wrong_password'));	
				}
			}else{
				return $this->sendResponse('fail', trans('api.not_authorise'));
			}
			
		}
		catch(Exception $e)
		{
			return $this->debugLog('#APIs '.$e->getMessage());
		}  
   }

   public function signup(Request $request)
   {
   		$rule = [
            'phone_number' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:6',   
            'device_id' => 'required',   
            'device_type' => 'required',   
        ];

        $msg = [
        	'phone_number.required' => trans('user.phone_number_required'),
        	'phone_number.unique' => trans('user.phone_number_unique'),
            'password.required' => trans('user.password_required'),
            'first_name.required' => trans('user.first_name_required'),
            'last_name.required' => trans('user.last_name_required'),
        ];

        $validate = Validator::make($request->all(), $rule,$msg);

        if ($validate->fails())
        {
             return $this->sendError('Validation Error.', ['error'=>$validate->errors()]);     
        }
	   	try
		{
			$data = request()->all();

			$user = $this->User;
			$user->first_name = $data['first_name'];
			$user->last_name = $data['last_name'];
			$user->phone_number = $data['phone_number'];
			$user->address = $data['address'];
			$user->password =  Hash::make($data['password']);
			$user->role_id =  '2';
			$user->device_id =  $data['device_id'];
			$user->device_type =  $data['device_type'];
			$user->save();	
			if($data['session_id']){
        		updateCartSizeProduct($data['device_id'],$user->id);
        	}
			$user['session'] = $this->UserSession->updateOrCreate(
            ['user_id' => $data['device_id']],
            ['user_id' => $user->id ,
            'session_id' => uniqid(),
        	'login'=>'yes']);
			
			return $this->sendResponse($user, trans('api.signup'));		
			
		}
		catch(Exception $e)
		{
			// dd($e);
			return $this->debugLog('#APIs '.$e->getMessage());
		}  
   }

   public function socialLogin(Request $request)
   {	
   		$rule = [
            'device_id' => 'required',   
            'device_type' => 'required',   
            'social_id' => 'required',   
            'social_type' => 'required',   
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails())
        {
             return $this->sendError('Validation Error.', ['error'=>$validate->errors()]);     
        }
   		try
		{
			$data = request()->all();
			$user = $this->User->where('device_id',$data['device_id'])->where('social_type',$data['social_type'])->where('social_id',$data['social_id'])->where('role_id','2')->first();

			if(!$user){
				
				$user = $this->User;
				$user->first_name = $data['first_name'];
				$user->last_name = $data['last_name'];
				$user->email = $data['email'];
				$user->role_id =  '2';
				$user->social_id =  $data['social_id'];
				$user->social_type =  $data['social_type'];
				$user->device_id =  $data['device_id'];
				$user->device_type =  $data['device_type'];
				$user->save();

				$session = $this->UserSession->updateOrCreate(
				            ['user_id' => $data['device_id']],
				            ['user_id' => $user->id ,
				            'session_id' => uniqid(),
				        	'login'=>'yes']);

				if($data['session_id']){
	        		updateCartSizeProduct($data['device_id'],$user->id);
	        	}

				return $this->sendResponse($session, trans('api.login'));		
			}else{
				$this->UserSession->where('user_id',$user->id)->delete();

				$session = $this->UserSession->updateOrCreate(
	            ['user_id' => $data['device_id']],
	            ['user_id' => $user->id ,
	            'session_id' => uniqid(),
	        	'login'=>'yes']);

				if($data['session_id']){
	        		updateCartSizeProduct($data['session_id'],$user->id);
	        	}
				
				return $this->sendResponse($session, trans('api.login'));
			}
			
		}
		catch(Exception $e)
		{
			return $this->debugLog('#APIs '.$e->getMessage());
		}  
   }

   public function logout(Request $request)
   {
   		$rule = [
            'user_id' => 'required',
            'session_id' => 'required',  
        ];

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails())
        {
             return $this->sendError('Validation Error.', ['error'=>$validate->errors()]);     
        }
	   	try
		{
			$data = request()->all();
			$session = $this->UserSession->where('user_id',$data['user_id'])->where('session_id',$data['session_id'])->delete();	
			return $this->sendResponse('1', trans('api.logout'));		
			
		}
		catch(Exception $e)
		{
			return $this->debugLog('#APIs '.$e->getMessage());
		}  
   }

   public function updateProfile(Request $request)
   {
   		try
		{
   			$data = request()->all();
   			$user = getSessionBySession($data['session_id']);
   			$user = $this->User->where('id',$user)->first();
   			$filename = $user->profile_picture;
   			$destinationPath = public_path().'/'. \Config::get('admin.image.profile_image');
   			if($request->hasfile('profile_picture'))
             {

               if(!is_dir($destinationPath)) {
            	mkdir($destinationPath,0777,true);
		        }
		        // $file = $request->file($getValue);
		        $getValue = $data['profile_picture'];
		        $extension = $getValue->getClientOriginalExtension(); // getting image extension
		        $filename = 'profile_img_'.$user->id.'.'.$extension;
		        if($user->profile_picture != null){
		            $filename = $user->getOriginal('profile_picture');
		        }
		        $getValue->move($destinationPath, $filename);
             }
   			$user_details=$this->User->where('id',$user->id)->update(['first_name'=>$data['first_name'],'last_name'=>$data['last_name'],'profile_picture'=>$filename]);
   			return $this->sendResponse('1', 'User Profile Update.');	
			
		}
		catch(Exception $e)
		{
			return $this->debugLog('#APIs '.$e->getMessage());
		}

   }

   public function getProfile(Request $request)
    {
    	try {

    		$user_details = $this->UserSession->with('userDetails')->where('session_id',request('session_id'))->first();

    		return $this->sendResponse($user_details, 'User Profile.');
    		
    	} catch (Exception $e) {

    		return $this->debugLog('#APIs '.$e->getMessage());

    	}
    }
}


