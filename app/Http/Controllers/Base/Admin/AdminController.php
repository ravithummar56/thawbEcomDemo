<?php

namespace App\Http\Controllers\Base\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Base\BaseController;
use Session;

class AdminController extends BaseController
{

    public function debugLog($e = NULL){
        if(\Config::get('admin.admin_mode') == 'live'){
            return response()->json("Something wen't wrong..!");
        }
        else
        {
            return response()->json("okay");
        }
    }

	

	public function success($type,$field)
	{	
		if (request()->ajax()) {
			return "<div class='alert alert-success' role='alert'><strong>".trans('common.success')."</strong> ".trans('message.'.$type,['attribute' => $field])."</div>";
		}
		return Session::flash('message', "<div class='alert alert-success' role='alert'><strong>".trans('common.success')."</strong> ".trans('message.'.$type,['attribute' => $field])."</div>");
	}

	public function warning($field)
	{
		if (request()->ajax()) {
			return "<div class='alert alert-success' role='alert'><strong>".trans('common.success')."</strong> ".trans('message.'.$type,['attribute' => $field])."</div>";
		}
		return Session::flash('message', "<div class='alert alert-success' role='alert'><strong>".trans('common.success')."</strong> ".trans('message.'.$type,['attribute' => $field])."</div>");
	}
    public function error($type,$field)
    {
        if (request()->ajax()) {
            return  "<div class='alert alert-danger' role='alert'><strong>".trans('common.success')."</strong> ".trans('message.'.$type,['attribute' => $field])."</div>";
        }
        
        return Session::flash('message', "<div class='alert alert-danger' role='alert'><strong>".trans('common.success')."</strong> ".trans('message.'.$type,['attribute' => $field])."</div>");
    }

    /**
     * [success description]
     * @param  string $type  type of the message
     * @param  string $field name of the  module
     *
     * === there are two type of message ===
     * if request is ajax then display via html rendering.
     * if request is normal then display via the session.
     */
    public function info($type,$field)
    {    
        if (request()->ajax()) {
            return "<div class='alert alert-info' role='alert'><strong>Info!</strong> ".trans('message.'.$type,['attribute' => $field])."</div>";
        }

        return Session::flash('message', "<div class='alert alert-info' role='alert'><strong>Info!</strong> ".trans('message.'.$type,['attribute' => $field])."</div>");
    }


}