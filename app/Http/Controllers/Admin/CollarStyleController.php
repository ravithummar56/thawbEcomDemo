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

class CollarStyleController extends AdminController
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

                $lists = $this->CollarSleeveStyle->orderBy('id','desc');
                if(request('searchtext')){
                    $search = request()->searchtext;
                    $lists->where(function($query) use ($search)
                    {
                        $query->orWhere('title','like', '%' . $search. '%'); 
                    });
                }

                $lists = $lists->paginate(10);
                return response()->json(
                   View::make('admin.collar_style.raw',compact('lists'))
                   ->render()
               );
                
            }

            return view('admin.collar_style.index');
        }
        catch(\Exception $e){
            return $this->debugLog('#CollarSleeveStyle'.$e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$kandora_style = $this->KandoraStyle->pluck('title','id');
        return view('admin.collar_style.create',compact('kandora_style'));
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
        	'kandora_style_id' => 'required',
            'title' => 'required',
            'image' => 'required',
        ];
        $msg = [
            'kandora_style_id.required'=>trans('validation_msg.kandora_style'),
            'title.required'=>trans('validation_msg.title'),
            'image.required'=>trans('validation_msg.image')
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
                $destinationPath = public_path().'/'. \Config::get('admin.image.collar_style');

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
            $collar_sleeve_style = $this->CollarSleeveStyle;
            $collar_sleeve_style->fill($data);
            $collar_sleeve_style->save();

            $this->success($this->created,trans('sidebar.collar_sleeve_style'));
            return redirect('admin/collar-style');
            
        } catch (Exception $e) {

            $this->debugLog('#CollarSleeveStyle'.$e);
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
        $editCollarSleeveStyle= $this->CollarSleeveStyle->find($id);
        $kandora_style = $this->KandoraStyle->pluck('title','id');
        return view('admin.collar_style.edit',compact('editCollarSleeveStyle','kandora_style'));
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
            'title' => 'required',
        ];
        $msg = [
            'title.required'=>trans('validation_msg.title'),
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
            
            $collar_sleeve_style = $this->CollarSleeveStyle->where('id',$id)->first();
            if($request->hasfile('image'))
            {   
                $destinationPath = public_path().'/'. \Config::get('admin.image.collar_style');

                // Create directory if it does not exist
                if(!is_dir($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = $collar_sleeve_style->image == "" ? time().'.'.$extension : $collar_sleeve_style->image; 
                $file->move($destinationPath, $filename);
                $data['image'] = $filename;
            }
            unset($data['_method'],$data['_token']);
            $collar_sleeve_style->update($data);
            $this->success($this->updated,trans('sidebar.collar_sleeve_style'));
            return redirect('admin/collar-style');
            
        } catch (Exception $e) {

            $this->debugLog('#CollarSleeveStyle'.$e);
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
       $deleteCollarSleeveStyle = $this->CollarSleeveStyle->where('id',$id)->first();
        // Value is not URL but directory file path
        $destinationPath = public_path().'/'. \Config::get('admin.image.collar_style').$deleteCollarSleeveStyle->image;
        if(File::exists($destinationPath)) {
            File::delete($destinationPath);
        }
        $deleteCollarSleeveStyle->delete();
        $message = $this->error($this->deleted,trans('sidebar.collar_sleeve_style'));
        return response()->json(['message'=>$message]);

    }
}
