<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Base\Admin\AdminController;
use Validator;
use Auth;
use DB;
use View;

class AuthController extends AdminController
{
    //login view
    public function loginView()
    {
    	return view('admin.auth.login');
    }

    //logged in to panel
    public function doLogin(Request $request)
    {   
        $data = $request->all();

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($data,$rules);

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try
        {
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'role_id'=>1]))
            {
                //auth success
                $user = auth()->user();   
                return response()->json(['status'=>true]);
            }
            else
            {
                session()->flash('msg',trans('login.loginValidate1'));
                return response()->json(['status'=>false]);
            }
        }
        catch(\Exception $e)
        {
    		$this->debugLog($e);
    	}
    }

    public function dashboard()
    { 
        
        return view('dashboard');
    }

    public function doLogout()
    {
        Auth::logout();
        
        return redirect('admin/login');
    }
}
