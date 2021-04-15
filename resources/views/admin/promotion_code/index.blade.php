@extends('layouts.admin')
@section('title')
{{trans('sidebar.promotionCode')}} {{trans('common.list')}}
@endsection

@section('pagelevel_css')
<style type="text/css">
	       
</style>
@endsection
@section('content')
 <div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                <h5>{{trans('sidebar.promotionCode')}} {{trans('common.list')}}</h5>
                </div>
                <div class="m-portlet__head-tools">
                   
                </div>
            </div>
            <div class="m-portlet__body">

              <div class="col-md-12">
                <div id="msg"></div>
                  @if ($message = Session::get('message'))
                   <div id="remove_msg"> {!! $message !!}</div> 
                    <!-- <span id="html-message"></span>  -->
                  @endif   

                   @if ($errors->any())
                      <div class="m-alert alert alert-danger " role="alert" id="m_form_1_msg">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
            </div>

             <div class="m-form m-form--label-align-right  m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6">
                        <div class="m-input-icon m-input-icon--left">
                         <input type="text" class="form-control input-circle-right m-input" placeholder="{{trans('common.search')}}" id="search-box"> 
                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                <span>
                                    <i class="la la-search"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <a  href="{{URL::to('admin/promotion-code/create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill float-right">
                            <span>
                                <i class="fa fa-user-plus"></i>
                                <span>
                                    {{trans('common.new')}} {{trans('sidebar.promotionCode')}}
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>

            </div>
            
                <!--begin: Datatable -->
                <div class="m_datatable m-datatable m-datatable--default m-datatable--loaded" id="promotion-code-list"> 
                    
                </div>
                <!--end: Datatable -->
            <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content"></div>
                        </div>
                        <div class="modal-dialog">
                            <div class="modal-content"></div>
                        </div>
                        <div class="modal-dialog" >
                            <div class="modal-content">
                                <div class="modal-header text-center" style="display: unset; border-bottom: none;">
                                     <h4>{{trans('common.deleteMsg')}}</h4> <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true" class="">×</span><span class="sr-only">{{trans('common.close')}}</span>
                                    </button>
                                </div>
                                  {{Form::hidden('userId','',array('class'=>'id'))}}

                                <!-- <div class="modal-body"></div> -->
                                <div class="modal-footer text-center" style="display: unset;">
                                 <button type="button" class="btn btn-default" data-dismiss="modal" id="model-close">{{trans('common.close')}}</button>
                                 <button type="button" class="btn btn-primary delete-user-record" id="OK">{{trans('common.ok')}}</button>
                                </div>
                            </div>
                      </div>
               </div> 
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagelevel_script')
<script type="text/javascript">
    $(document).ready(function() 
    {
        var page = '';
        var qstring = '' ;
        var basePath = baseUrl;
        var searchtext = '';

        getCode(qstring);

        $(document).on('click', '.pagination li a', function (e) {
              e.preventDefault();
              page = $(this).attr('href').split('page=')[1];
              var qstring = '&searchtext=' + searchtext + '&page=' + page +'&userstatus=' ;              
              getCode(qstring);
           });

            $(document).on('keyup','#search-box',function(e){
              e.preventDefault();
              searchtext = $(this).val();
              var qstring = '&searchtext=' + searchtext; 
              getCode(qstring);
            });

       function getCode(qstring)
       {   
         $.ajax({
             type: 'GET',
             url : basePath+'/promotion-code?' + qstring,
             dataType: 'json',
         }).done(function (data) 
         {
            $('#promotion-code-list').html(data);     
         }).fail(function () {
             alert('{{trans('common.pageNotLoad')}}');
         });
       }

       $(document).on('click','.delete-user',function(e){                  
         e.preventDefault();    
         $('#delete_modal').modal('show');
         var id =$(this).data('id');                  
         $('.id').val(id);
         var form_data = $('#delete_modal');

       });
      $(document).on('click','.delete-user-record',function(e){
               e.preventDefault();
               var id = $('.id').val(); 
               var page ='';
               var _token = "{{ csrf_token() }}";
               
                 $.ajax({
                       url: baseUrl +'/promotion-code/'+id ,
                       type: 'DELETE',  
                       data:{_token:_token},
                   }).done(function(result){
                        $('#form-errors').html("");               
                        $('#msg').html(result.message);
                        setTimeout(function()
                        {
                         $('#msg').html("");
                        // location.reload();
                        }, 3000);
                      $('#delete_modal').modal('hide');
                      // getCode("",page,basePath);
                      getCode(qstring);
                  });
          });
    });

 </script>  
@endsection
