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


class KandoraStyleController extends AdminController
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

                $lists = $this->KandoraStyle->orderBy('id','desc');
                if(request('searchtext')){
                    $search = request()->searchtext;
                    $lists->where(function($query) use ($search)
                    {
                        $query->orWhere('title','like', '%' . $search. '%'); 
                    });
                }

                $lists = $lists->paginate(10);
                return response()->json(
                   View::make('admin.kandora_style.raw',compact('lists'))
                   ->render()
               );
                
            }

            return view('admin.kandora_style.index');
        }
        catch(\Exception $e){

            $this->debugLog('#KandoraStyle'.$e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kandora_style.create');
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
            'title' => 'required',
            'image' => 'required',
        ];
        $msg = [
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
                $destinationPath = public_path().'/'. \Config::get('admin.image.kandora_style');

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
            $kandora_style = $this->KandoraStyle;
            $kandora_style->fill($data);
            $kandora_style->save();

            $this->success($this->created,trans('sidebar.kandora_style'));
            return redirect('admin/kandora-style');
            
        } catch (Exception $e) {

            $this->debugLog('#KandoraStyle'.$e);
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
        $editKandoraStyle= $this->KandoraStyle->find($id);
        return view('admin.kandora_style.edit',compact('editKandoraStyle'));
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
            
            $kandora_style = $this->KandoraStyle->where('id',$id)->first();
            if($request->hasfile('image'))
            {   
                $destinationPath = public_path().'/'. \Config::get('admin.image.kandora_style');

                // Create directory if it does not exist
                if(!is_dir($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = $kandora_style->image == "" ? time().'.'.$extension : $kandora_style->image; 
                $file->move($destinationPath, $filename);
                $data['image'] = $filename;
            }
            unset($data['_method'],$data['_token']);
            $kandora_style->update($data);
            $this->success($this->updated,trans('sidebar.kandora_style'));
            return redirect('admin/kandora-style');
            
        } catch (Exception $e) {

            $this->debugLog('#KandoraStyle'.$e);
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
       $deleteKandoraStyle = $this->KandoraStyle->where('id',$id)->first();
        // Value is not URL but directory file path
        $destinationPath = public_path().'/'. \Config::get('admin.image.kandora_style').$deleteKandoraStyle->image;
        if(File::exists($destinationPath)) {
            File::delete($destinationPath);
        }
        $deleteKandoraStyle->delete();
        $message = $this->error($this->deleted,trans('sidebar.kandora_style'));
        return response()->json(['message'=>$message]);

    }
}
