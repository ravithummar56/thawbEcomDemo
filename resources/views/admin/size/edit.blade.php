@extends('layouts.admin')
@section('title')
{{trans('common.edit')}} {{trans('sidebar.size')}} 
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
                                {{trans('common.edit')}} {{trans('sidebar.size')}}
                            </h3>
                        </div>
                    </div>
                </div>
                
                    
                
               <!--   begin::Portlet -->

               {{  Form::open(array('url'=>'admin/size/'.$editSize->id , 'method' =>'PUT','class'=>'m-form m-form--fit m-form--label-align-right','files'=>'true'))}}
                

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
                                        {{trans('sidebar.size')}} {{trans('user.name')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::text('size_name',$editSize->size_name,array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter').' '.trans('sidebar.size').' '.trans('user.name')))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('size_name') }}</span> 
                                </div>
                            </div> 
                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                        {{trans('sidebar.size')}} {{trans('common.value')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::text('value',$editSize->value,array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter').' '.trans('sidebar.size').' '.trans('common.value')))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('value') }}</span> 
                                </div>
                            </div>  
                            
                            
                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                    {{trans('common.status')}}:
                                </label>
                                <div class="m-radio-inline ml-3 ">
                                   @if($editSize->status == "active")
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="active" checked="true">
                                            {{trans('common.active')}}
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="user">
                                            {{trans('common.deactive')}}
                                            <span></span>
                                        </label>
                                    @else
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="active" >
                                            {{trans('common.active')}}
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="user" checked="true">
                                            {{trans('common.deactive')}}
                                            <span></span>
                                        </label>

                                    @endif
                                </div>
                            </div>
                        </div>       
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit text-center">
                        <div class="m-form__actions m-form__actions">
                            {{ Form::submit(trans('common.submit'),array('class'=>'btn btn-primary')) }}
                            <a href="{{ URL::to('admin/size')}}" class='btn btn-secondary'>{{trans('common.cancel')}}</a>
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