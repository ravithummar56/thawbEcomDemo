<?php

namespace App\Http\Controllers\Base\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Base\BaseController;

class ApiController extends BaseController
{
   public function sendResponse($result, $message)
    {

        if($result == "fail")
        {
            $response = [
            'status' => 0,
            'message' => $message];  
            return response()->json($response, 200); 
        }
        if($result == null)
        {
            $response = [
            'status' => 0,
            'message' => $message];            
        }
        else
        {
            $response = [
            'status' => 1,
            'data'    => $result,
            'message' => $message];

        }       
    	
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 406)
    {
    	$response = [
            'status' => 0,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
