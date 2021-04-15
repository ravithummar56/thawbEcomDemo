@extends('layouts.admin')
@section('title')
{{trans('common.status')}} {{trans('common.list')}}
@endsection

@section('pagelevel_css')
<style type="text/css">
  .circle {
    height: 50px;
    width: 50px;
    background-color: #555;
    border-radius: 50%;
  }
</style> 
@endsection
@section('content')
 <div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                <h5>{{trans('common.status')}} {{trans('common.list')}}</h5>

                </div>
                <div class="m-portlet__head-tools">
                   <span style="color: #dc3545" ><b>*</b>{{trans('common.donotchange')}}</span>
                </div>
            </div>
            <div class="m-portlet__body">

              <div class="col-md-12">
                  @if ($message = Session::get('message'))
                   <div id="remove_msg"> {!! $message !!}</div> 
                    <!-- <span id="html-message"></span>  -->
                  @endif   
                <div id="msg"></div>

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

             
            
                <!--begin: Datatable -->
                <div class="m_datatable m-datatable m-datatable--default m-datatable--loaded" id="status-list"> 
                    
                </div>
                <!--end: Datatable -->
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

        getStatus(qstring);

        
       function getStatus(qstring)
       {   
         $.ajax({
             type: 'GET',
             url : basePath+'/status?' + qstring,
             dataType: 'json',
         }).done(function (data) 
         {
            $('#status-list').html(data);     
         }).fail(function () {
             alert('Posts could not be loaded.');
         });
       }

       $(document).on('click','.delete',function(e){                  
         e.preventDefault();    
         $('#delete_modal').modal('show');
         var id =$(this).data('id');                  
         $('.id').val(id);
         var form_data = $('#delete_modal');

       });
      $(document).on('click','.delete-record',function(e){
               e.preventDefault();
               var id = $('.id').val(); 
               var page ='';
               var _token = "{{ csrf_token() }}";
               
                 $.ajax({
                       url: baseUrl +'/status/'+id ,
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
                      // getStatus("",page,basePath);
                      getStatus(qstring);
                  });
          });
    });

 </script>  
@endsection
