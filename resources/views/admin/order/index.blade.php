@extends('layouts.admin')
@section('title')
{{trans('sidebar.order')}} {{trans('common.list')}} 
@endsection
@section('pagelevel_css')
<style type="text/css">
a.panel 
{
    font-weight: 400;
    letter-spacing: 1px;
    margin-right: 6px;
    font-size: 18px;
    text-transform: capitalize;
}
a.panel:hover
{
      text-decoration: none !important;
}
a.active
{
    background-color :rgba(93, 120, 255, 0.1);
    padding: 6px;
    border-radius: 22px;
}
.list-inline-item:last-child
{
  width: 200px;
}
</style>
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-content">
    	<div class="m-portlet m-portlet--mobile">
        	<div class="m-portlet__head">
            	<div class="m-portlet__head-caption">
                	<h5>{{trans('sidebar.order')}} {{trans('common.list')}}</h5>
                </div>
                <div class="m-portlet__head-tools m-subheader">
					
					
				</div>
			</div>
			 <div class="m-portlet__body">
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
                    <div class="col-xl-3 col-md-3 ">
                        <div class='input-group pull-right' id='m_daterangepicker_6'>
							<input type='text' class="form-control m-input" readonly  placeholder="{{trans('common.selectdate')}}"/>
							<div class="input-group-append">
								<span class="input-group-text">
									<i class="la la-calendar-check-o"></i>
								</span>
							</div>
						</div>
                    </div>
                </div>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>

            </div>
			<span id="succes-message"></span>
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                   <div class="row align-items-center">
                    <div class="col-md-12 order-2 order-xl-1">
                             <ul class="list-inline">
                                <li class="list-inline-item"><a href="#" class="panel active order-filter" data-value= "0">{{trans('status.All')}} <span class="m-badge m-badge--primary m-badge--wide">{{$allcnt}}</span> </a> |</li>
                                <li class="list-inline-item"><a href="#" class="panel order-filter" data-value="1">{{trans('status.In Processing')}}  <span class="m-badge m-badge--primary m-badge--wide">{{$processingCnt}}</span> </a> |</li>
                                <li class="list-inline-item"><a href="#" class="panel order-filter" data-value="2">{{trans('status.Confirmed')}} <span class="m-badge m-badge--primary m-badge--wide">{{$comCnt}}</span> </a> |</li>
                                <li class="list-inline-item"><a href="#" class="panel order-filter" data-value="3">{{trans('status.Ready To Dispatch')}} <span class="m-badge m-badge--primary m-badge--wide">{{$readytodiscnt}}</span> </a> |</li>
                                <li class="list-inline-item"><a href="#" class="panel order-filter" data-value="4">{{trans('status.Dispatched')}} <span class="m-badge m-badge--primary m-badge--wide">{{$discnt}}</span> </a> |</li>
                                <li class="list-inline-item"><a href="#" class="panel order-filter" data-value="5">{{trans('status.Delivered')}} <span class="m-badge m-badge--primary m-badge--wide">{{$dilvcnt}}</span> </a> |</li>
                                <li class="list-inline-item"><a href="#" class="panel order-filter" data-value="6">{{trans('status.Cancel')}} <span class="m-badge m-badge--primary m-badge--wide">{{$cancnt}}</span></a> </li>
                            </ul>
                          
                    </div>
                  </div>

                    <div class="m-separator m-separator--dashed"></div>
                    <div class="row align-items-center">
                    <div class="col-md-12 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">							
                           	<div class="col-lg-3">
                           		{{Form::select('paymentStatus',$payment_status,'',array('class' => 'form-control form-filter input-sm', 'id' => "payment" ,'placeholder' => 'Update Payment Status'))}}
                          	</div>
                          	<div class="col-lg-3">
                           		{{Form::select('orderStatus',$order_status,'',array('class' => 'form-control form-filter input-sm', 'id' => "order" ,'placeholder' => 'Update Order Status'))}}
                          	</div>
                        </div>
                    </div>
                 </div>
                </div>
                <!--begin: Datatable -->
                <div class="m_datatable m-datatable m-datatable--default m-datatable--loaded" id="order-list">
                                   	 
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
        var start ="";
        var end = "";
        var order_status = "";
        var payment_type = "";
        var payment_status = "";

        getOrder(qstring);

        $(document).on('click', ".select-all",function (){
            $("input:checkbox").prop('checked', $("input:checkbox").prop("checked"));
        });

        $(document).on('click', '.pagination li a', function (e) 
        {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            var qstring =  'payment_status=' + payment_status +'&payment_type=' + payment_type +'&searchtext=' + searchtext + '&page=' + page +'&start=' + start + '&end=' + end  + '&order_status=' +order_status ;     
            getOrder(qstring);
        });

        $(document).on('click', '.order-filter', function (e) 
        {
            e.preventDefault();
            order_status = $(this).data('value'); 
            var qstring =  'payment_status=' + payment_status +'&payment_type=' + payment_type +'&searchtext=' + searchtext + '&page=' + page +'&start=' + start + '&end=' + end  + '&order_status=' +order_status ;    
            getOrder(qstring);
        });

        $('#m_daterangepicker_6').on('apply.daterangepicker', function(ev, picker)
        {
            start = picker.startDate.format('YYYY-MM-DD');
            end = picker.endDate.format('YYYY-MM-DD');
             var qstring =  'payment_status=' + payment_status +'&payment_type=' + payment_type +'&searchtext=' + searchtext + '&page=' + page +'&start=' + start + '&end=' + end  + '&order_status=' +order_status ;
            getOrder(qstring);
        });

        $(document).on('keyup','#search-box',function(e)
        {
            e.preventDefault();
            searchtext = $(this).val();              
           var qstring =  'payment_status=' + payment_status +'&payment_type=' + payment_type +'&searchtext=' + searchtext + '&page=' + page +'&start=' + start + '&end=' + end  + '&order_status=' +order_status ;
            getOrder(qstring);
        });

        $(document).on('click', ".paymentType_cod , .paymentType_payfort",function (){
            payment_type = $(this).data('value');
            if(payment_type == 'cod')
            {
                $('.payfort').css('color','#78797c');
                $('.cod').css('color','#2c2e3e');

            }else
            {   
                $('.cod').css('color','#78797c');
                $('.payfort').css('color','#2c2e3e');
            }
            var qstring =  'payment_status=' + payment_status +'&payment_type=' + payment_type +'&searchtext=' + searchtext + '&page=' + page +'&start=' + start + '&end=' + end  + '&order_status=' +order_status ;
            getOrder(qstring);
        });

        $(document).on('click', ".payment_status",function (){
            payment_status = $(this).data('id');
            var qstring =  'payment_status=' + payment_status +'&payment_type=' + payment_type +'&searchtext=' + searchtext + '&page=' + page +'&start=' + start + '&end=' + end  + '&order_status=' +order_status ;
            getOrder(qstring);
        });
        
       function getOrder(qstring)
       {   
       	
         $.ajax({
             type: 'GET',
             url : basePath+'/order?' + qstring,
             dataType: 'json',
         }).done(function (data) 
         {
            $('#order-list').html(data);     
         }).fail(function () {
             alert('{{trans('common.pageNotLoad')}}');
         });
       }

        $("input[type=checkbox]").change(function()
        {
            var ischecked= $(this).is(':checked');
        if(!ischecked)
        {
            $('.submit').addClass('disabled');
        }
        else
            $('.submit').removeClass('disabled');
        });
        // Change payment status
            $(document).on('change', "#payment",function ()
            {
               
                var valueSelected = this.value;
                var page = '';
                var favourite = [];
                $('input[type=checkbox]:checked').each(function() 
                {
                 if($(this).val() != "on"){

                    favourite.push($(this).val());
                    }
                });
                if(favourite == ""){
                    return  true;
                }

                

                $.ajax({
                    type:'POST',
                    data: { id: favourite , value: valueSelected},
                    url: baseUrl + "/payment-status" ,
                    success:function(result) 
                    {
                        
                        
                        $('#succes-message').html(result.message);
                        var status = result.paymentStatus;
                        $.each(result.pId, function(k, v) 
                        {
                            $('.p_status[data-id= '+v+']').text(result.paymentStatus);
                        });
                        $("input:checkbox").prop('checked', false); 
                        getOrder(qstring);
                    }
                });

            });
    // Change order status
        
        $(document).on('change', "#order",function ()
        {
            
            var valueSelected = this.value;
            var page = '';
            var favourite = [];
            $('input[type=checkbox]:checked').each(function() 
            {
                if($(this).val() != "on"){

                    favourite.push($(this).val());
                }
            });
            if(favourite == ""){
                return  true;
            }               
            $.ajax({
                type:'POST',
                data: { id: favourite , value: valueSelected},
                url: baseUrl + "/order-status" ,
                    success:function(result) 
                    {

                    $('#succes-message').html(result.message);
                    var status = result.orderStatus;
                    $.each(result.pId, function(k, v) 
                    {
                        $('.p_status[data-id= '+v+']').text(result.orderStatus);
                    });
                    $("input:checkbox").prop('checked', false);
                     getOrder(qstring);
                    }
                });
           

        });
	});
	var a = moment().subtract(29, "days"),
        t = moment();   
 	$("#m_daterangepicker_6").daterangepicker(
 		{
 			buttonClasses:"m-btn btn",
 			applyClass:"btn-primary",
 			cancelClass:"btn-secondary",
 			startDate:a,
 			endDate:t,
 			ranges:{
 				{{trans('common.today')}}:[moment(),moment()],
 				{{trans('common.yesterday')}}:[moment().subtract(1,"days"),moment().subtract(1,"days")],
 				"{{trans('common.Last-7-Days')}}":[moment().subtract(6,"days"),moment()],
 				"{{trans('common.Last-30-Days')}}":[moment().subtract(29,"days"),moment()],
 				"{{trans('common.This-Month')}}":[moment().startOf("month"),moment().endOf("month")],
 				"{{trans('common.Last-Month')}}":[moment().subtract(1,"month").startOf("month"),
 				moment().subtract(1,"month").endOf("month")]
 			}
 		},
			function(a,t,n){
				$("#m_daterangepicker_6 .form-control").val(a.format("MM/DD/YYYY")+" / "+t.format("MM/DD/YYYY"))
			}
		);
</script>
@endsection
