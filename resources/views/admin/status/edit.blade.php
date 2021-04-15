@extends('layouts.admin')
@section('title')
Edit Color 
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
                                Edit Color
                            </h3>
                        </div>
                    </div>
                </div>
                
                    
                
               <!--   begin::Portlet -->

               {{  Form::open(array('url'=>'admin/color/'.$editColor->id , 'method' =>'PUT','class'=>'m-form m-form--fit m-form--label-align-right','files'=>'true'))}}
                

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
                                        Color Name:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::text('color_name',$editColor->color_name,array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> "Enter Fabric Name"))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('color_name') }}</span> 
                                </div>
                            </div> 
                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                        Color Code:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::text('value',$editColor->value,array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> "Enter Color Code"))}}

                               <span class="m-form__help" style="color: red">{{ $errors->first('value') }}</span> 
                                </div>
                            </div>  
                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                        Color Picture:
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                {{ Form::file('image',array('class'=>'form-control form-control-danger m-input','data-required'=>'1','placeholder'=> "Enter Color Picture"))}}

                                <span class="m-form__help" style="color: red">{{ $errors->first('image') }}</span> 
                                <img class="mt-3" src="{{URL::to('public/'.config('admin.image.color').$editColor->image)}}"  width="25%">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                   Gender:
                                </label>

                                <div class="m-radio-inline ml-3 ">
                                    @if($editColor->male == "yes")
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="male" value="yes" checked >
                                            Male
                                            <span></span>
                                        </label>
                                    @else
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="male" value="yes" >
                                            Male
                                            <span></span>
                                        </label>
                                    @endif 
                                    @if($editColor->female == "yes")
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="female" value="yes" checked >
                                            Female
                                            <span></span>
                                        </label>
                                    @else
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="female" value="yes" >
                                            Female
                                            <span></span>
                                        </label>
                                    @endif                                
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example_input_full_name" class="col-form-label col-lg-3 col-sm-12">
                                    Status:
                                </label>
                                <div class="m-radio-inline ml-3 ">
                                   @if($editColor->status == "active")
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="active" checked="true">
                                            Active
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="user">
                                            Deactive
                                            <span></span>
                                        </label>
                                    @else
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="active" >
                                            Active
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="user" checked="true">
                                            Deactive
                                            <span></span>
                                        </label>

                                    @endif
                                </div>
                            </div>
                        </div>       
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit text-center">
                        <div class="m-form__actions m-form__actions">
                            {{ Form::submit('submit',array('class'=>'btn btn-primary')) }}
                            <a href="{{ URL::to('admin/fabric')}}" class='btn btn-secondary'>Cancel</a>
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