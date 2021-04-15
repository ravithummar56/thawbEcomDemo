@extends('layouts.admin')
@section('title')
{{trans('common.edit')}} {{trans('sidebar.user')}} 
@endsection
@section('css')

@endsection
@section('content')
 <div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="col-md-6">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{trans('common.edit')}} {{trans('sidebar.user')}}
                            </h3>
                        </div>
                    </div>
                </div>
                
                    
                
               <!--   begin::Portlet -->

               {{  Form::open(array('url'=>'admin/users/'.$editUser->id , 'method' =>'PUT','class'=>'m-form m-form--fit m-form--label-align-right','files'=>'true'))}}
                

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
                                        {{trans('user.first_name')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::text('first_name',$editUser->first_name,array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter').' ' . trans('user.first_name')))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('first_name') }}</span> 
                                </div>
                            </div>

                             <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                        {{trans('user.last_name')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::text('last_name',$editUser->last_name,array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter').' ' . trans('user.last_name')))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('last_name') }}</span> 
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                        {{trans('login.email')}} :
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                               {{ Form::text('email',$editUser->email,array('class'=>'form-control m-input','data-required'=>'1','placeholder'=> trans('common.enter').' ' . trans('login.email') , 'readonly'))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                    {{trans('user.role')}}:
                                </label>
                                <div class="m-radio-inline ml-3 ">
                                    @if($editUser->role_id == 1)
                                        <label class="m-radio">
                                            <input type="radio" name="role_id" value="1" checked="true">
                                            {{trans('user.admin')}}
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="role_id" value="2">
                                            {{trans('sidebar.user')}}
                                            <span></span>
                                        </label>
                                    @else
                                        <label class="m-radio">
                                            <input type="radio" name="role_id" value="1" >
                                            {{trans('user.admin')}}
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="role_id" value="2" checked="true">
                                            {{trans('sidebar.user')}}
                                            <span></span>
                                        </label>

                                    @endif
                                
                                </div>
                            </div>    

                             <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                        {{trans('user.profile_picture')}}:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                @if(!is_null($editUser->profile_picture))
                                    <img id="theImg" src="{{$editUser->image_path}}" width="25%" />
                                @endif
                                {{ Form::file('profile_picture',array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter') .' ' .trans('user.profile_picture')))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('name') }}</span> 
                                </div>
                            </div>
                        </div>        
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit text-center">
                        <div class="m-form__actions m-form__actions">
                            {{ Form::submit(trans('common.submit'),array('class'=>'btn btn-primary')) }}
                            <a href="{{ URL::to('admin/users')}}" class='btn btn-secondary'>{{trans('common.cancel')}}</a>
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