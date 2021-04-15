<div class="row">
<div class="col-md-6">
<h4>{{trans('sidebar.order')}} {{trans('common.status')}}</h4>
<div class="table-responsive">

    <table width="50%" class="m-dt-table table table-bordered table-hover" id="html_table">
        <thead class="m-datatable__head">
            <tr class="m-datatable__row">
            <th>{{trans('sidebar.order')}} {{trans('common.status')}} </th>
            <th>{{trans('common.id')}}</th>
            </tr>
        </thead>
        <tbody class="m-datatable__body">
            @forelse($list['order_status'] as $row) 
                
                <tr class="m-datatable__row">
                <td><span class="rediz" data-id="{{$row->id}}">{{trans('status.'.$row->status_value)}}</span></td>
                <td>{{$row->id}}</td>
                </tr>
                
                @empty
                <tr class="odd gradeX">
                    <td class="text-center" colspan="8"> {{trans('common.noData')}}</td>
                </tr> 
            @endforelse
        </tbody>
    </table>
</div>

</div>
<div class="col-md-6">
<h4>{{trans('common.payment')}} {{trans('common.status')}}</h4>
    <div class="table-responsive">
        <table width="50%" class="m-dt-table table table-bordered table-hover" id="html_table">
            <thead class="m-datatable__head">
                <tr class="m-datatable__row">
                <th>{{trans('common.payment')}} {{trans('common.status')}}</th>
                <th>{{trans('common.id')}}</th>
               
                </tr>
            </thead>
            <tbody class="m-datatable__body">
                @forelse($list['payment_status'] as $row) 
                    <tr class="m-datatable__row">
                    <td><span class="rediz" data-id="{{$row->id}}">{{trans('status.'.$row->status_value)}}</span></td>
                    <td>{{$row->id}}</td>
                    </tr>
                    
                    @empty
                    <tr class="odd gradeX">
                        <td class="text-center" colspan="8"> {{trans('common.noData')}}</td>
                    </tr> 
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>