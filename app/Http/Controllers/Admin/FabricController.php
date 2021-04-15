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
use App\Models\FabricColor;
use App\Models\FabricType;


class FabricController extends AdminController
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

                $lists = $this->Fabric->orderBy('id','desc');
                if(request('searchtext')){
                    $search = request()->searchtext;
                    $lists->where(function($query) use ($search)
                    {
                        $query->orWhere('fabric_name','like', '%' . $search. '%'); 
                    });
                }

                $lists = $lists->paginate(10);
                return response()->json(
                   View::make('admin.fabric.raw',compact('lists'))
                   ->render()
               );
                
            }

            return view('admin.fabric.index');
        }
        catch(\Exception $e){

            $this->debugLog('#Fabric'.$e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $color = $this->Color->pluck('color_name','id');
       
        return view('admin.fabric.create',compact('color'));
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
            'fabric_name' => 'required',
            'fabric_description_en' => 'required|max:80',
            'fabric_description_es' => 'required|max:80',
            'image' => 'required',
        ];
        if(isset($data['fabric_color'])){
            $rules['fabric_color'] = 'required';
        }
        
        $msg = [
            'fabric_name.required'=>trans('validation_msg.fabric_name'),
            'fabric_description_en.required'=>trans('validation_msg.fabric_description_en'),
            'fabric_description_es.required'=>trans('validation_msg.fabric_description_es'),
            'fabric_description_en.max'=>trans('validation_msg.fabric_description_max'),
            'fabric_description_es.max'=>trans('validation_msg.fabric_description_max'),
            'fabric_color.required'=>trans('validation_msg.fabric_color'),
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
                $destinationPath = public_path().'/'. \Config::get('admin.image.fabric');

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
            unset($data['fabric_color'],$data['fabric_type']);
            $fabric = $this->Fabric;
            $fabric->fill($data);
            $fabric->save();
            if(isset($data['fabric_color'])){   
                foreach ($request['fabric_color'] as $color) {
                    $fabric_color = new FabricColor;
                    $fabric_color->fabric_id = $fabric->id;
                    $fabric_color->color_id = $color;
                    $fabric_color->save();
                }
            }
            $this->success($this->created,trans('sidebar.fabric'));
            return redirect('admin/fabrics');
            
        } catch (Exception $e) {

            $this->debugLog('#Fabric'.$e);
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
        $editFabric= $this->Fabric->find($id);
        $editFabricColor = $this->FabricColor->where('fabric_id',$id)->pluck('color_id');
        $color = $this->Color->pluck('color_name','id');
        return view('admin.fabric.edit',compact('editFabric','editFabricColor','color'));
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
            'fabric_name' => 'required',
            'fabric_description_en' => 'required|max:80',
            'fabric_description_es' => 'required|max:80',
        ];
        if(isset($data['fabric_color'])){
            $rules['fabric_color'] = 'required';
        }
        
        $msg = [
            'fabric_name.required'=>trans('validation_msg.fabric_name'),
            'fabric_description_en.required'=>trans('validation_msg.fabric_description_en'),
            'fabric_description_es.required'=>trans('validation_msg.fabric_description_es'),
            'fabric_description_en.max'=>trans('validation_msg.fabric_description_max'),
            'fabric_description_es.max'=>trans('validation_msg.fabric_description_max'),
            'fabric_color.required'=>trans('validation_msg.fabric_color'),
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
            
            $fabric = $this->Fabric->where('id',$id)->first();
            if($request->hasfile('image'))
            {   
                $destinationPath = public_path().'/'. \Config::get('admin.image.fabric');

                // Create directory if it does not exist
                if(!is_dir($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = $fabric->image == "" ? time().'.'.$extension : $fabric->image; 
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
            unset($data['fabric_color'],$data['fabric_type']);
            $fabric->update($data);
            $this->FabricColor->where('fabric_id',$id)->delete();
            foreach ($request['fabric_color'] as $color) {
                $fabric_color = new FabricColor;
                $fabric_color->fabric_id = $fabric->id;
                $fabric_color->color_id = $color;
                $fabric_color->save();
            }

            
            $this->success($this->updated,trans('sidebar.fabric'));
            return redirect('admin/fabrics');
            
        } catch (Exception $e) {

            $this->debugLog('#Fabric'.$e);
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
       $deleteFabric = $this->Fabric->where('id',$id)->first();
        // Value is not URL but directory file path
        $destinationPath = public_path().'/'. \Config::get('admin.image.fabric').$deleteFabric->image;
        if(File::exists($destinationPath)) {
            File::delete($destinationPath);
        }
        $deleteFabric->delete();
        $message = $this->error($this->deleted,trans('sidebar.fabric'));
        return response()->json(['message'=>$message]);

    }
}
