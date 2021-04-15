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


class PromotionCodeController extends AdminController
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

                $lists = $this->PromotionCode->orderBy('id','desc');
                $lists = $lists->paginate(10);
                return response()->json(
                   View::make('admin.promotion_code.raw',compact('lists'))
                   ->render()
               );
                
            }

            return view('admin.promotion_code.index');
        }
        catch(\Exception $e){

            return $this->debugLog('#PromotionCode'.$e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.promotion_code.create');
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
            'code' => 'required|unique:promotion_codes',
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'limit' => 'required',
        ];
        $msg=[

            'code.required' => trans('promotion_code.code_required'),
            'code.unique' => trans('promotion_code.code_unique'),
            'title.required' => trans('promotion_code.title_required'),
            'start_date.required' => trans('promotion_code.start_date_required'),
            'end_date.required' => trans('promotion_code.end_date_required'),
            'limit.required' => trans('promotion_code.end_date_required'),
        ];

        $validator = Validator::make($data,$rules,$msg);

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {


            $promotion_code = $this->PromotionCode;
            $promotion_code->title = $data['title'];
            $promotion_code->code = $data['code'];
            $promotion_code->limit = $data['limit'];
            $promotion_code->start_date = date('Y-m-d',strtotime($data['start_date']));
            $promotion_code->end_date = date('Y-m-d',strtotime($data['end_date']));
            $promotion_code->save();

            $this->success($this->created,trans('sidebar.promotionCode'));
            return redirect('admin/promotion-code');

            
        } catch (Exception $e) {
            return $this->debugLog('#PromotionCode'.$e);
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
        $editCode = $this->PromotionCode->find($id);
        return view('admin.promotion_code.edit',compact('editCode'));
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
            'code' => 'required|unique:promotion_codes,'.$id,
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $msg=[

            'code.required' => trans('promotion_code.code_required'),
            'code.unique' => trans('promotion_code.code_unique'),
            'title.required' => trans('promotion_code.title_required'),
            'start_date.required' => trans('promotion_code.start_date_required'),
            'end_date.required' => trans('promotion_code.end_date_required'),
        ];

        $validator = Validator::make($data,$rules,$msg);

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {

            $data['start_date'] = date('Y-m-d',strtotime($data['start_date']));
            $data['end_date'] = date('Y-m-d',strtotime($data['end_date']));

            unset($data['_token'],$data['_method']);
            $updateLead = $this->PromotionCode->where('id',$id)->update($data);
            $this->success($this->updated,trans('sidebar.promotionCode'));
            return redirect('admin/promotion-code');            
        } catch (Exception $e) {
            return $this->debugLog('#PromotionCode'.$e);
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
        $deletePromotionCode = $this->PromotionCode->where('id',$id)->first();
        
        // $deleteSize->delete();
        $message = $this->error($this->deleted,trans('sidebar.promotionCode'));
        return response()->json(['message'=>$message]);
    }
}
