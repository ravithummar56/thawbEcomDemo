@extends('layouts.admin')
@section('title')
{{trans('common.create')}} {{trans('sidebar.shipping_charg')}}  
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
                                {{trans('common.create')}} {{trans('sidebar.shipping_charg')}} 
                            </h3>
                        </div>
                    </div>
                </div>
                
                    
                
               <!--   begin::Portlet -->

               {{  Form::open(array('url'=>'admin/shipping-charg/' , 'method' =>'POST','class'=>'m-form m-form--fit m-form--label-align-right','files'=>'true'))}}
                

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
                                        {{trans('sidebar.shipping_charg')}} {{trans('user.name')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::text('title','',array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter').' '.trans('sidebar.shipping_charg').' '.trans('user.name')))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('title') }}</span> 
                                </div>
                            </div> 
                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                        {{trans('sidebar.shipping_charg')}} {{trans('common.value')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::text('charges','',array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter').' '.trans('sidebar.shipping_charg').' '.trans('common.value')))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('charge') }}</span> 
                                </div>
                            </div>  
                        </div>        
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit text-center">
                        <div class="m-form__actions m-form__actions">
                            {{ Form::submit(trans('common.submit'),array('class'=>'btn btn-primary')) }}
                            <a href="{{ URL::to('admin/shipping-charg')}}" class='btn btn-secondary'>{{trans('common.cancel')}}</a>
                        </div>
                    </div>
                    
               {{Form::close()}}
                        
                   
                
            </div>
        </div>
    </div>
</div> 
@endsection
@section('pagelevel_script') 
@endsection