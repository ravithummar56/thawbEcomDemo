<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Base\Admin\AdminController;
use Validator;
use Auth;
use DB;
use View;
use File;

class ColorController extends AdminController
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

                $lists = $this->Color->orderBy('id','desc');
                if(request('searchtext')){
                    $search = request()->searchtext;
                    $lists->where(function($query) use ($search)
                    {
                        $query->orWhere('color_name','like', '%' . $search. '%'); 
                    });
                }

                $lists = $lists->paginate(10);
                return response()->json(
                   View::make('admin.color.raw',compact('lists'))
                   ->render()
               );
                
            }

            return view('admin.color.index');
        }
        catch(\Exception $e){

            $this->debugLog('#Color'.$e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.color.create');
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
        $rules = [
            'color_name' => 'required',
            'image' => 'required',
        ];
        $msg = [
            'color_name.required'=>trans('validation_msg.color_name'),
            'image.required'=>trans('validation_msg.color_image'),
        ];  

        $validator = Validator::make($data,$rules,$msg);

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        try 
        {
            
            if($request->hasfile('image'))
            {   
                $destinationPath = public_path().'/'. \Config::get('admin.image.color');

                // Create directory if it does not exist
                if(!is_dir($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                $file->move($destinationPath, $filename);
                $data['image'] = $filename;
            }
            $color = $this->Color;
            $color->fill($data);
            $color->save();

            $this->success($this->created,trans('sidebar.color'));
            return redirect('admin/color');
            
        } catch (Exception $e) {

            $this->debugLog('#Color'.$e);
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
        $editColor= $this->Color->find($id);
        return view('admin.color.edit',compact('editColor'));
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
            'color_name' => 'required',
        ];
        $msg = [
            'color_name.required'=>trans('validation_msg.color_name'),
        ];

        $validator = Validator::make($data,$rules,$msg);

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
       try 
        {
            
            $color = $this->Color->where('id',$id)->first();
            if($request->hasfile('image'))
            {   
                $destinationPath = public_path().'/'. \Config::get('admin.image.color');

                // Create directory if it does not exist
                if(!is_dir($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = $color->image == "" ? time().'.'.$extension : $color->image; 
                $file->move($destinationPath, $filename);
                $data['image'] = $filename;
            }
            if(!$request->has('male'))
            {
                $data['male'] = "";
            }

            if(!$request->has('female'))
            {
                $data['female'] = "";
            }
            unset($data['_method'],$data['_token']);
            $color->update($data);

            $this->success($this->updated,trans('sidebar.color'));
            return redirect('admin/color');
            
        } catch (Exception $e) {

            $this->debugLog('#Color'.$e);
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
        $deletecolor = $this->Color->where('id',$id)->first();
        // Value is not URL but directory file path
        $destinationPath = public_path().'/'. \Config::get('admin.image.color').$deletecolor->image;
        if(File::exists($destinationPath)) {
            File::delete($destinationPath);
        }
        $deletecolor->delete();
        $message = $this->error($this->deleted,trans('sidebar.color'));
        return response()->json(['message'=>$message]);
    }
}
