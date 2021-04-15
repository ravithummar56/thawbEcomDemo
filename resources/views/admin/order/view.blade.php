@extends('layouts.admin')
@section('title')
{{trans('common.view')}} {{trans('sidebar.order')}}
@endsection
@section('pagelevel_css')
<style type="text/css">
      .sameHead
      {
        border: 4px solid #f7f7fa;
        margin-bottom: 0 !important;
        padding: 2% 1% 2% 2% !important;
        border-bottom: 0;
      }
      .m-logo 
      {
        PADDING: 9%;
        MARGIN-LEFT: 43%;
      }
</style>
@endsection
@section('content')
 <div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet">
                    <div class="m-portlet__body m-portlet__body--no-padding">
                        <div class="m-invoice-2">
                            <div class="m-invoice__wrapper">
                                <div class="m-invoice__head" style="background-color: #f7f8fa;">
                                    <div class="m-invoice__container m-invoice__container--centered" >
                                        <div class="m-invoice__logo pt-3" >
                                            <div >
                                                <h1>
                                                    {{strtoupper(trans('order.invoice'))}}

                                                </h1>
                                                <span class="m-badge m-badge--success m-badge--wide">
                                                                                        #{{$myOrder->invoice_number}}
                                                                                    </span>
                                                
                                            </div>
                                            <a >
                                                <img  src="{{URL::to('public/default/logo2.png')}}">
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="m-invoice__head">
                                    <div class="m-invoice__container m-invoice__container--centered" >
                                        <div class="m-invoice__items pt-5">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">
                                                    {{strtoupper(trans('order.invoice').' ' .trans('common.date'))}}
                                                </span>
                                                <span class="m-invoice__text">                               
                                                    {{date("M-d-Y", strtotime($myOrder->orderDate))}}
                                                </span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">
                                                    {{strtoupper(trans('sidebar.order').' ' .trans('common.number'))}}
                                                </span>
                                                <span class="m-invoice__text">
                                                    {{$myOrder->order_id}}
                                                </span>
                                            </div>

                                             <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">
                                                    {{strtoupper(trans('order.customer').' ' .trans('user.name'))}}
                                                </span>
                                                <span class="m-invoice__text">
                                                    {{$myOrder['customerDetails']->first_name}} {{ $myOrder['customerDetails']->last_name}}
                                                </span>
                                            </div>

                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">
                                                     {{strtoupper(trans('order.customer'). ' ' .trans('order.address'))}}
                                                </span>
                                                <span class="m-invoice__text">
                                                   {{$myOrder['customerAddress']->address}}
                                                    
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-invoice__body m-invoice__body--centered pt-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>{{trans('sidebar.product')}} {{trans('common.image')}}</th>
                                                    <th class="text-center">{{trans('sidebar.product')}} {{trans('user.name')}}</th>
                                                    <th class="text-center">{{trans('sidebar.fabric')}}</th>
                                                    <th class="text-center">{{trans('sidebar.color')}}</th>
                                                    <th class="text-center">{{trans('sidebar.size')}}</th>
                                                    <th class="text-center">{{trans('product.price')}}</th>
                                                    <th class="text-center">{{trans('product.stock')}}</th>
                                                    <th class="text-center">{{trans('common.total')}}</th>
                                                </tr>
                                            </thead>
                                            {{-- <tbody>
                                                @forelse($myOrder['orderItems'] as $row) 
                                
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="media">
                                                            <a class="thumbnail pull-center" href="#"> 

                                                                @if($row['productImagesSingel'] )
                                                                <img class="media-object" src="{{URL::to('/public'.config('admin.image.product').$row->product_id.'/'.$row['productImagesSingel']->image) }}" style="width: 50px;height: 50px;border-radius: 5px;">
                                                                @else
                                                                <img class="media-object" src="{{URL::to('/picture_not_available2.png')}}" style="width: 50px;height: 50px;border-radius: 5px;">
                                                                @endif
                                                             </a>
                                                        </div> 
                                                    </td>
                                                    <td class="text-center">
                                                       {{$row['productDetails']->product_name}}
                                                    </td>
                                                    <td class="text-center">
                                                    @if($row->fabric_name != null)
                                                       {{$row->fabric_name}}({{$row->fabric_type}})
                                                    @endif
                                                    </td>
                                                    <td class="text-center">
                                                    @if($row->colur_name != null)
                                                       {{$row->colur_name}}
                                                    @endif
                                                    </td>
                                                    <td class="text-center">
                                                    @if($row->size_name != null)
                                                       {{$row->size_name}}
                                                    @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{$row->sell_price}}
                                                    </td>
                                                    <td class="text-center">
                                                      {{$row->quantity}}
                                                    </td>
                                                    <td class="text-center">
                                                        {{$row->total}}
                                                    </td>
                                                   
                                                </tr>
                                                @empty
                                                <tr class="odd gradeX">
                                                     <td class="text-center" colspan="8"> {{trans('common.noData')}}</td>
                                                </tr> 
                                                @endforelse
                                            </tbody> --}}
                                        </table>
                                    </div>
                                </div>
                                <div class="m-invoice__head">
                                    <div class="m-invoice__container m-invoice__container--centered" >
                                        <div class="m-invoice__items pt-5">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">
                                                    {{strtoupper(trans('sidebar.order').' ' .trans('common.status'))}}
                                                </span>
                                                <span class="m-invoice__text">                               
                                                    {{orderStatus($myOrder->order_status_id)}}
                                                </span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">
                                                    @if($myOrder->order_status_id == 5)
                                                    {{strtoupper(trans('common.delivered_date'))}}
                                                    @else
                                                    {{strtoupper(trans('common.estimate_delivered_date'))}}
                                                    @endif
                                                </span>
                                                <span class="m-invoice__text">     
                                                    @if($myOrder->order_status_id == 5)                        
                                                        {{$myOrder->delivered_date}}
                                                    @else
                                                        <input type="text"  class="form-control change_date " id="m_datepicker_1"  data-order_id = "{{$myOrder->id}}" readonly  value="{{$myOrder->delivered_date}}" placeholder="Select date"/>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">
                                                    {{strtoupper(trans('common.payment').' ' .trans('common.status'))}}
                                                </span>
                                                <span class="m-invoice__text">
                                                {{paymentStatus($myOrder->payments_status_id)}}
                                                </span>
                                            </div>

                                             <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">
                                                    {{strtoupper(trans('common.payment').' ' .trans('common.method'))}}
                                                </span>
                                                <span class="m-invoice__text">
                                                    {{strtoupper($myOrder->payments_type)}}
                                                </span>
                                            </div>

                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">
                                                    {{strtoupper(trans('order.extra_note'))}}
                                                </span>
                                                <span class="m-invoice__text">
                                                    {{strtoupper($myOrder->extra_note)}}
                                                </span>
                                            </div>

                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">
                                                    {{strtoupper(trans('order.tag_name'))}}
                                                </span>
                                                <span class="m-invoice__text">
                                                    {{strtoupper($myOrder->tag_name)}}
                                                </span>
                                            </div>

                                            <div class="m-invoice__item" style="padding-left: 3rem; font-size: 20px;">
                                                <span class="m-invoice__subtitle">
                                                     {{strtoupper(trans('common.total').' ' .trans('product.price'))}}
                                                </span>
                                                <span class="m-invoice__text m--font-danger text-center">
                                                   <strong>AED {{$myOrder->total}}</i></strong>   
                                                    
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    $("#m_datepicker_1").datepicker({
        autoclose: true,
       todayHighlight:!0,
         format: 'yyyy/mm/dd',
    });

    $(document).on('change', ".change_date",function ()
        {
           var basePath = baseUrl;
           var date= $(this).val();
           alert(date);
           var order_id= $(this).data('order_id');
                     
            $.ajax({
                type:'GET',
                data: { date: date , order_id:order_id },
                url: baseUrl + "/change-delivery-date" ,
                    success:function(result) 
                    {

                        alert('ok');
                    }  
                });
           

        });
</script>
@endsection