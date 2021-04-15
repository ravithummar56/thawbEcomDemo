
@extends('layouts.admin')
@section('title')
{{trans('common.edit')}} {{trans('sidebar.product')}} 
@endsection
@section('pagelevel_css')
   <link href="http://admincast.com/adminca/preview/admin_1/html/assets/css/main.min.css" rel="stylesheet" />
   <style type="text/css">
     #image_preview .col-md-3
      {
        text-align: center;
      }

     button.remove
      {
        margin-top: 10px;
        margin-bottom: 10px;
      }
      img#img-upload {
        width: 100%;
        padding: 20px;
    }
    .tab-content {
        border-top: 1px solid #5c6bc0;
        padding-top: 25px;
    }
    .disabled {
        pointer-events: none;
        cursor: default;
    }
    .select2-container 
    {
        width: 100% !important;
    }
   </style>

@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                <h5>{{trans('common.edit')}} {{trans('sidebar.product')}} </h5>
                <div id="msg"></div>
                </div>
                <div class="m-portlet__head-tools">
                    
                </div>
            </div>
            <div class="m-portlet__body">
                   <div class="col-lg-10 mx-auto">

                        {{  Form::open(array('url'=>'admin/product/'.$editProduct->id , 'method' =>'PUT','class'=>'m-form m-form--fit m-form--label-align-right','files'=>'true'))}}
                        <input type="hidden" name="product_id" class="productid" value="{{$editProduct->id}}">
                            <div class="row ">
                                <div class="col border-right">
                                    <div class="col-sm-12 form-group mb-4">
                                    <label>{{trans('sidebar.product')}} {{trans('user.name')}} <b>(In English)</b></label>
                                    {{ Form::text('english[product_name]',$editProduct->en_product_name,array('class'=>'form-control form-control-solid form-control-danger m-input','id'=>'product_title','data-required'=>'1','placeholder'=> trans('common.enter').' '.trans('sidebar.product').' '.trans('user.name')))}}
                                    <span class="m-form__help m--font-danger">{{ $errors->first('english.product_name') }}</span> 
                                    </div>
                                    <div class="col-sm-12 col-lg-12">
                                    <label>{{trans('sidebar.product')}}  {{trans('product.description')}}  <b>(In English)</b></label>
                                    {{ Form::textarea('english[description]',$editProduct->en_description,array('class'=>'form-control form-control-solid form-control-danger m-input summernote','data-required'=>'1'))}}
                                    <span class="m-form__help m--font-danger">{{ $errors->first('english.description') }}</span> 
                                    </div>
                                     
                                </div>

                                <div class="col" style="margin-bottom: 15px">
                                    <div class="col-sm-12 form-group mb-4">
                                    <label>{{trans('sidebar.product')}} {{trans('user.name')}} <b>(In Arabic)</b></label>
                                    {{ Form::text('arabic[product_name]',$editProduct->es_product_name,array('class'=>'form-control form-control-solid form-control-danger m-input','id'=>'product_title','data-required'=>'1','placeholder'=> trans('common.enter').' '.trans('sidebar.product').' '.trans('user.name')))}}
                                    <span class="m-form__help m--font-danger">{{ $errors->first('arabic.product_name') }}</span> 
                                    </div>
                                    
                                     <div class="col-sm-12 col-lg-12">
                                    <label>{{trans('sidebar.product')}}  {{trans('product.description')}}  <b>(In Arabic)</b></label>
                                    {{ Form::textarea('arabic[description]',$editProduct->es_description,array('class'=>'form-control form-control-solid form-control-danger m-input summernote','data-required'=>'1'))}}
                                    <span class="m-form__help m--font-danger">{{ $errors->first('arabic.description') }}</span> 
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3 form-group mb-4">
                                    <label>{{trans('product.manufacturing')}} {{trans('product.price')}}</label>
                                    {{ Form::text('manufacturing_price',$editProduct->manufacturing_price,array('class'=>'form-control form-control-solid form-control-danger m-input','data-required'=>'1','placeholder'=>trans('common.enter').' '. trans('product.mrp')))}}
                                    <span class="m-form__help m--font-danger">{{ $errors->first('manufacturing_price') }}</span> 
                                </div>
                                 <div class="col-sm-3 form-group mb-4">
                                    <label>{{trans('product.price')}} </label>
                                    {{ Form::text('price',$editProduct->price,array('class'=>'form-control form-control-solid form-control-danger m-input','data-required'=>'1','placeholder'=>trans('common.enter').' '. trans('product.price')))}}
                                    <span class="m-form__help m--font-danger">{{ $errors->first('price') }}</span> 
                                </div>
                                <div class="col-sm-3 form-group mb-4">
                                    <label>{{trans('product.sell')}} {{trans('product.price')}} </label>
                                    {{ Form::text('sell_price',$editProduct->sell_price,array('class'=>'form-control form-control-solid form-control-danger m-input','data-required'=>'1','placeholder'=>trans('common.enter').' '. trans('product.sell').' '.trans('product.price')))}}
                                    <span class="m-form__help m--font-danger">{{ $errors->first('sell_price') }}</span> 
                                </div>
                                <div class="col-sm-3 form-group mb-4">
                                    <label>{{trans('product.stock')}}</label>
                                    {{ Form::text('quantity',$editProduct->quantity,array('class'=>'form-control form-control-solid form-control-danger m-input','data-required'=>'1','placeholder'=> trans('common.enter').' '.trans('product.stock')))}}
                                    <span class="m-form__help m--font-danger">{{ $errors->first('quantity') }}</span> 
                                </div>

                            </div>
                            
                            <div class="row">
                                <div class="col-sm-4 form-group mb-4">

                                     <label>{{trans('sidebar.color')}}</label><br>
                                     {{ Form::select('colors[]',$colors,$get_colors,array('class'=>'form-control m-select2 form-control-solid','multiple'=> "multiple",'id'=>'var_color'))}}
                                     <span class="m-form__help m--font-danger">{{ $errors->first('colors') }}</span> 
                                 </div>                               
                                 <div class="col-sm-4 form-group mb-4">
                                      <label>{{trans('sidebar.size')}}</label><br>
                                     {{ Form::select('size[]',$size,$get_size,array('class'=>'form-control m-select2 form-control-solid','multiple'=> "multiple",'id'=>'var_size'))}}
                                     <span class="m-form__help m--font-danger">{{ $errors->first('size') }}</span> 
                                 </div>
                                <div class="col-sm-4 form-group mb-4">
                                       <label>{{trans('sidebar.fabric')}}</label><br>
                                     {{ Form::select('fabric[]',$fabric,$get_fabric,array('class'=>'form-control m-select2 form-control-solid','multiple'=> "multiple",'id'=>'var_fabric'))}}
                                     <span class="m-form__help m--font-danger">{{ $errors->first('fabric') }}</span> 
                                 </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group mb-4">
                                    <label>{{trans('common.gender')}}</label><br>
                                    @if($editProduct->gender == 'male')
                                        <label class="m-radio">
                                            <input type="radio" name="gender" value="male" checked>
                                            {{trans('common.male')}}
                                            <span></span>
                                        </label>
                                        <label class="m-radio ml-3">
                                            <input type="radio" name="gender" value="female">
                                            {{trans('common.female')}}
                                            <span></span>
                                        </label>
                                    @else
                                   
                                        <label class="m-radio">
                                            <input type="radio" name="gender" value="male" >
                                            {{trans('common.male')}}
                                            <span></span>
                                        </label>
                                        <label class="m-radio ml-3">
                                            <input type="radio" name="gender" value="female" checked>
                                            {{trans('common.female')}}
                                            <span></span>
                                        </label>
                                    @endif
                                    <span class="m-form__help m--font-danger">{{ $errors->first('stock_status') }}</span> 

                                 </div>

                                 <div class="col-sm-3 form-group mb-4">
                                    <label>{{trans('common.status')}}</label><br>
                                    @if($editProduct->status == 'active')
                                    <label class="ui-switch switch-icon mr-3 mb-0">
                                        <input type="checkbox" checked="" name="status">
                                        <span></span>
                                    </label>
                                    @else
                                    <label class="ui-switch switch-icon mr-3 mb-0">
                                        <input type="checkbox"  name="status">
                                        <span></span>
                                    </label>
                                    @endif
                                    <span class="m-form__help m--font-danger">{{ $errors->first('stock_status') }}</span> 
                                 </div> 

                                 <div class="col-sm-3 form-group mb-4">
                                    <label>Style {{trans('common.type')}}</label><br>
                                    @if($editProduct->type == 'kuwaiti')
                                      <label class="m-radio">
                                            <input type="radio" name="type" value="kuwaiti" checked>
                                            Kuwaiti
                                            <span></span>
                                        </label>
                                        <label class="m-radio ml-3">
                                            <input type="radio" name="type" value="emirati">
                                            Emirati
                                            <span></span>
                                        </label>
                                        <label class="m-radio ml-3">
                                            <input type="radio" name="type" value="saudi">
                                            Saudi
                                            <span></span>
                                        </label>
                                    @elseif($editProduct->type == 'emirati')
                                      <label class="m-radio">
                                            <input type="radio" name="type" value="kuwaiti" >
                                            Kuwaiti
                                            <span></span>
                                        </label>
                                        <label class="m-radio ml-3">
                                            <input type="radio" name="type" value="emirati" checked>
                                            Emirati
                                            <span></span>
                                        </label>
                                        <label class="m-radio ml-3">
                                            <input type="radio" name="type" value="saudi">
                                            Saudi
                                            <span></span>
                                        </label>
                                    @else
                                      <label class="m-radio">
                                            <input type="radio" name="type" value="kuwaiti" >
                                            Kuwaiti
                                            <span></span>
                                        </label>
                                        <label class="m-radio ml-3">
                                            <input type="radio" name="type" value="emirati">
                                            Emirati
                                            <span></span>
                                        </label>
                                        <label class="m-radio ml-3">
                                            <input type="radio" name="type" value="saudi" checked>
                                            Saudi
                                            <span></span>
                                        </label>
                                    @endif
                                        
                                    <span class="m-form__help m--font-danger">{{ $errors->first('type') }}</span> 

                                 </div>
                                  
                                 <div class="col-sm-3 form-group mb-4">
                                    <label>{{trans('sidebar.product')}} {{trans('common.type')}}</label><br>
                                    @if($editProduct->product_type == 'main_product')
                                        <label class="m-radio">
                                            <input type="radio" name="product_type" value="main_product" checked>
                                           {{trans('product.main')}} {{trans('sidebar.product')}}
                                            <span></span>
                                        </label>
                                        <label class="m-radio ml-3">
                                            <input type="radio" name="product_type" value="finish_product">
                                            {{trans('product.finish')}} {{trans('sidebar.product')}}
                                            <span></span>
                                        </label>
                                    @else
                                        <label class="m-radio">
                                            <input type="radio" name="product_type" value="main_product" >
                                           {{trans('product.main')}} {{trans('sidebar.product')}}
                                            <span></span>
                                        </label>
                                        <label class="m-radio ml-3">
                                            <input type="radio" name="product_type" value="finish_product" checked>
                                            {{trans('product.finish')}} {{trans('sidebar.product')}}
                                            <span></span>
                                        </label> 
                                    @endif
                                    <span class="m-form__help m--font-danger">{{ $errors->first('stock_status') }}</span> 

                                 </div> 
                            </div>
                            <div class="row">
                                <div class="col-sm-12 form-group mb-4">

                                    <label>{{trans('sidebar.product')}} {{trans('common.image')}}</label><br>
                                    <input type="file" class="form-control" id="products_image" name="product_image[]"  multiple/>
                                    <div class="row" id="image_preview"></div>
                                    <span class="m-form__help m--font-danger">{{ $errors->first('products_image ') }}</span>
                                   
                                 </div>
                                 
                            </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit" style="padding: 1.5%; padding-left: 40%;">
                    <div class="row">
                            {{ Form::submit(trans('common.submit'),array('class'=>'btn btn-primary m-btn m-btn--custom m-btn--icon btn-submit-product mr-3')) }}
                            <a href="{{URL::to('admin/product')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon btn-back" >{{trans('common.cancel')}}</a>

                    </div>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection

@section('pagelevel_script')

<script src="{{URL::to('public/assets/demo/default/custom/components/forms/widgets/select2.js')}}" type="text/javascript"></script>
<script src="{{URL::to('public/assets/demo/default/custom/components/forms/widgets/summernote.js')}}" type="text/javascript"></script>
<script type="text/javascript">    
$(document).ready(function () 
{   get_images();
    $(document).on('change','#products_image',function(e){
     preview_images();
     
    });
    function preview_images()
    {
        var total_file = document.getElementById("products_image").files.length;
        for (var i = 0; i < total_file; i++)
        {
            $('#image_preview').append("<div class='col-md-3 mt-2   '><img class='img-responsive' src='" + URL.createObjectURL(event.target.files[i]) + "' width='100' height='100'/></br><button class='remove'>Remove</button></div>");
        }

        $('body').on('click', '.remove', function (e)
        {

            $(this).parent().remove('');

            // var file = $(this).parent().attr('file');
            // for (var i = 0; i < storedFiles.length; i++)
            // {
            //     if (storedFiles[i].name == file)
            //     {
            //         storedFiles.splice(i, 1);
            //         break;
            //     }
            // }
        });
    }
    $('#var_color').select2();
    $('#var_fabric').select2();
    $('#var_size').select2();
   function get_images(){
     
      $('#img-upload').hide();
      var imagePath = $('#baseUrl').val()+"/public{{config('admin.image.product')}}";
      var id = $('.productid').val();
      
        $.ajax
        ({ 
            url: baseUrl +'/product/get-images/'+id ,
            type: 'GET',
            dataType: "json",
            async:false,
            success: function(result)
            {
                $.each(result.images, function(key, value) 
                { 
                    $('#image_preview').prepend('<div class="col-md-3 mt-2 multiImage" data-id="'+key+'"><img data-pid="'+id+'" data-id="'+key+'" id="Otherimages" src="'+ imagePath + id+'/' + value +'" width="100" height="100"/></br><button class="remove" data-id="'+key+'" >{{trans('common.remove')}}</button></div>'); 
                });

                              
            }
        });

  }
});

 $(document).ready(function() 
 {

    $('.btn-file :file').on('fileselect', function (event, label)
    {
        $('#theSingleImg').remove();
         $('#img-upload').show();
    });
 
  });

  $(document).on('click', '.remove', function(event) 
  {
      event.preventDefault();
      var removeId = $(this).data('id');

      var btn = $(this);
        if( typeof removeId !== 'undefined' ) 
        {
              
              var imgId = $('#Otherimages').data('pid');
              var img = '';

               $.ajax
              ({ 
                  url: baseUrl +'/product/remove-images/'+removeId ,
                  type: 'GET',
                  dataType: "json",
                  async:false,
                  success: function(result)
                  {
                    if(result)
                    {
                     $('.multiImage[data-id= '+removeId+']').remove();
                    }
                    $('#msg').html(result.message);
                        setTimeout(function()
                        {
                          
                         $('#msg').html("");
                        // location.reload();
                        }, 3000);
                  }
              });
        }

  });

</script>
@endsection
