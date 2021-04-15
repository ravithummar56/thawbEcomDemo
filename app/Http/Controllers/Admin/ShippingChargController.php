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

class ShippingChargController extends AdminController
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

                $lists = $this->ShippingCharg->orderBy('id','desc');
                if(request('searchtext')){
                    $search = request()->searchtext;
                    $lists->where(function($query) use ($search)
                    {
                        $query->orWhere('title','like', '%' . $search. '%'); 
                    });
                }

                $lists = $lists->paginate(10);
                return response()->json(
                   View::make('admin.shipping_charge.raw',compact('lists'))
                   ->render()
               );
                
            }

            return view('admin.shipping_charge.index');
        }
        catch(\Exception $e){
            return $this->debugLog('#shipping_charg'.$e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shipping_charge.create');
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
        try 
        {
           
            $size = $this->ShippingCharg;
            $size->fill($data);
            $size->save();

            $this->success($this->created,trans('sidebar.shipping_charg'));
            return redirect('admin/shipping-charg');
            
        } catch (Exception $e) {

            $this->debugLog('#ShippingCharg'.$e);
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
        $editShippingCharg= $this->ShippingCharg->find($id);
        return view('admin.shipping_charge.edit',compact('editShippingCharg'));
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
       try 
        {
           
            $ShippingCharg = $this->ShippingCharg->where('id',$id)->first();
            unset($data['_method'],$data['_token']);
            $ShippingCharg->update($data);
            $this->success($this->updated,trans('sidebar.shipping_charg'));
            return redirect('admin/shipping-charg');
            
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
       $deleteShippingCharg = $this->ShippingCharg->where('id',$id)->first();
        
        // $deleteSize->delete();
        $message = $this->error($this->deleted,trans('sidebar.shipping_charg'));
        return response()->json(['message'=>$message]);

    }
}
