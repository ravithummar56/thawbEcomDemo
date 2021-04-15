@extends('layouts.admin')
@section('title')
{{trans('common.edit')}} {{trans('sidebar.promotionCode')}} 
@endsection
@section('css')

@endsection
@section('content')
 <div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{trans('common.edit')}} {{trans('sidebar.promotionCode')}}
                            </h3>
                        </div>
                    </div>
                </div>
                
                    
                
               <!--   begin::Portlet -->

               {{  Form::open(array('url'=>'admin/promotion-code/'.$editCode->id , 'method' =>'PUT','class'=>'m-form m-form--fit m-form--label-align-right','files'=>'true'))}}
                

                      <div class="m-portlet__body">
                        <div class="col-md-12 mx-auto">
                            @if ($message = Session::get('Success'))
                               <div class="alert alert-success alert-dismissible fade show" role="alert">
                                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                   {{ $message }}
                               </div>
                            @endif  
                        </div>
                
                        <div class="col-md-12 mx-auto">
                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                        {{trans('promotion_code.title')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::text('title',$editCode->title,array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter').' ' .trans('promotion_code.title')))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('title') }}</span> 
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                        {{trans('promotion_code.code')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::text('code',$editCode->code,array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter').' ' .trans('promotion_code.code')))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('code') }}</span> 
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                        {{trans('promotion_code.limit')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::number('limit',$editCode->limit,array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter').' ' .trans('promotion_code.limit')))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('limit') }}</span> 
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">
                                    {{trans('promotion_code.start_date')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <input type="text" readonly class="form-control" name="start_date" id="m_datepicker_1" readonly placeholder="Select date"/ value="{{date('m/d/Y',strtotime($editCode->start_date))}}">
                                    <span class="m-form__help" style="color: red">{{ $errors->first('start_date') }}</span> 
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">
                                    {{trans('promotion_code.end_date')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <input type="text" readonly class="form-control" name="end_date" id="m_datepicker_1" readonly placeholder="Select date"/ value="{{date('m/d/Y',strtotime($editCode->end_date))}}">
                                    <span class="m-form__help" style="color: red">{{ $errors->first('end_date') }}</span> 
                                </div>
                            </div>
                        </div>        
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit text-center">
                        <div class="m-form__actions m-form__actions">
                            {{ Form::submit(trans('common.submit'),array('class'=>'btn btn-primary')) }}
                            <a href="{{ URL::to('admin/promotion-code')}}" class='btn btn-secondary'>{{trans('common.cancel')}}</a>
                        </div>
                    </div>
                    
               {{Form::close()}}
                        
                   
                
            </div>
        </div>
    </div>
</div> 
@endsection
@section('pagelevel_script') 
<script type="text/javascript">
    $("#m_datepicker_1, #m_datepicker_1_validate").datepicker({
        todayHighlight: !0,
        orientation: "bottom left",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    });
    $("#m_datepicker_1_modal").datepicker({
        todayHighlight: !0,
        orientation: "bottom left",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    });
</script>
@endsection