<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Base\Admin\AdminController;
use Validator;
use Auth;
use DB;
use View;
use Hash;

class UserController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            if(request()->ajax())
            {

                $lists = $this->User->orderBy('id','desc');
                if(request('searchtext')){
                    $search = request()->searchtext;
                    $lists->where(function($query) use ($search)
                    {
                        $query->orWhere('first_name','like', '%' . $search. '%')
                              ->orWhere('last_name', 'like', '%' . $search. '%') 
                              ->orWhere('email', 'like', '%' . $search. '%'); 
                    });
                }

                $lists = $lists->paginate(10);
                return response()->json(
                   View::make('admin.users.raw',compact('lists'))
                   ->render()
               );
                
            }

            return view('admin.users.index');
        }
        catch(\Exception $e){

            $this->debugLog('#User'.$e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = request()->all();
        // $rules = [
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ];
        // $msg=[

        //     'email.required' => trans('user.email_required'),
        //     'password.required' => trans('user.password_required'),
        // ];

        // $validator = Validator::make($data,$rules,$msg);

        // if($validator->fails())
        // {
        //     return redirect()
        //         ->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }
        try
        {
            
            if($request->hasfile('profile_picture'))
            {
                $destinationPath = public_path().'/'. \Config::get('admin.image.profile_image');
                // Create directory if it does not exist
                if(!is_dir($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }

                $file = $request->file('profile_picture');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                $file->move($destinationPath, $filename);
                $data['profile_picture'] = $filename;
            }
            $data['password'] = Hash::make($data['password']);
            $user = $this->User;
            $user->fill($data);
            $user->save();

            $this->success($this->created,trans('sidebar.user'));
            return redirect('admin/users');
        }
        catch(\Exception $e){

            $this->debugLog('#User'.$e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editUser = $this->User->find($id);
        return view('admin.users.edit',compact('editUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->all();
        $rules = [
            'email' => 'required|email',
            // 'password' => 'required',
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
           
            $updateUser = $this->User->where('id',$id)->first();

             if($request->hasfile('profile_picture'))
            {
                $destinationPath = public_path().'/'. \Config::get('admin.image.profile_image');
                // Create directory if it does not exist
                if(!is_dir($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }

                $file = $request->file('profile_picture');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = $updateUser->profile_picture == null ? time().'.'.$extension :  $updateUser->profile_picture;
                $file->move($destinationPath, $filename);
                $data['profile_picture'] = $filename;
            }

            unset($data['_token'],$data['_method']);
            $updateLead = $this->User->where('id',$id)->update($data);
            
            $this->success($this->updated,trans('sidebar.user'));
            return redirect('admin/users');
        }
        catch(\Exception $e){

            $this->debugLog('#User'.$e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $removeUser = $this->User->where('id',$id)->delete();
        $message = $this->error($this->deleted,trans('sidebar.user'));
        return response()->json(['message' => $message]);
    }
}
