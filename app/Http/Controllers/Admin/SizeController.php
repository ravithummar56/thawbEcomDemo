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

class SizeController extends AdminController
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

                $lists = $this->Size->orderBy('id','desc');
                if(request('searchtext')){
                    $search = request()->searchtext;
                    $lists->where(function($query) use ($search)
                    {
                        $query->orWhere('size_name','like', '%' . $search. '%'); 
                    });
                }

                $lists = $lists->paginate(10);
                return response()->json(
                   View::make('admin.size.raw',compact('lists'))
                   ->render()
               );
                
            }

            return view('admin.size.index');
        }
        catch(\Exception $e){

            $this->debugLog('#Size'.$e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.size.create');
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
            'size_name' => 'required',
            'value' => 'required',
        ];
        $msg = [
            'size_name.required'=>trans('validation_msg.size_name'),
            'value.required' => trans('validation_msg.value'),
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
           
            $size = $this->Size;
            $size->fill($data);
            $size->save();

            $this->success($this->created,trans('sidebar.size'));
            return redirect('admin/size');
            
        } catch (Exception $e) {

            $this->debugLog('#Size'.$e);
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
        $editSize= $this->Size->find($id);
        return view('admin.size.edit',compact('editSize'));
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
            'size_name' => 'required',
            'value' => 'required',
        ];
        $msg = [
            'size_name.required'=>trans('validation_msg.size_name'),
            'value.required' => trans('validation_msg.value'),
        ];

        $validator = Validator::make($data,$rules, $msg);

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
       try 
        {
           
            $size = $this->Size->where('id',$id)->first();
            unset($data['_method'],$data['_token']);
            $size->update($data);
            $this->success($this->updated,trans('sidebar.size'));
            return redirect('admin/size');
            
        } catch (Exception $e) {

            $this->debugLog('#Size'.$e);
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
       $deleteSize = $this->Size->where('id',$id)->first();
        
        $deleteSize->delete();
        $message = $this->error($this->deleted,trans('sidebar.size'));
        return response()->json(['message'=>$message]);

    }
}
