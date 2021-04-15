<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest 
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   
        $rules = [];
        $rules['username'] = 'required';
        if($this->method() == 'POST'){
            $rules['email'] = 'required|email|unique:users';
            $rules['mobile_number'] = 'numeric';
            $rules['password'] = 'required';
        }

        if($this->method() == 'PUT'){
            $rules['email'] = 'required|email|unique:users,email,' . $this->user;
        }
        return $rules;
        
    }

    public function messages(){
        return [
            'username.required' => 'Please enter name',
            'email.required' => 'Please enter email address',
            'email.email' => 'Please enter valid email address',
            'email.unique' => 'Email address already exists',
            'password.required' => 'Please enter password',

        ];
    }
}
