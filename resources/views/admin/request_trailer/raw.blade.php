<div class="table-responsive">
    
<table width="100%" class="m-dt-table table table-bordered table-hover" id="html_table">
    <thead class="m-datatable__head">
        <tr class="m-datatable__row">
        <th>{{trans('common.srno')}}</th>
         <th>{{trans('user.name')}}</th>
         <th>{{trans('user.phone_number')}}</th>
         <th>{{trans('user.promo_code')}}</th>
         <th>{{trans('user.pay')}}</th>
        {{-- <th>{{trans('common.action')}}</th> --}}
        </tr>
    </thead>
    <tbody class="m-datatable__body">
        @forelse($lists as $row) 
            <tr class="m-datatable__row">
                <td>&nbsp;&nbsp;{{ ($lists ->currentpage()-1) * $lists ->perpage() + $loop->index + 1 }}</td>
                <td>{{$row->first_name}} {{$row->last_name}}</td>
                <td>{{$row->phone_number}}</td>
                <td>{{$row->code}}</td>
                <td>{{$row->payed}}</td>
                {{-- <td><a href="{{ URL::to('admin/promotion-code/'.$row->id.'/edit') }}"><i class="fa fa-pencil"></i></a> &nbsp; <a href="#" class="delete-user" data-id="{{$row->id}}"> <i class="fa fa-times-circle-o"></i></a></td> --}}
            </tr>
        @empty
        <tr class="odd gradeX">
            <td class="text-center" colspan="9"> {{trans('common.noData')}}</td>
        </tr> 
        @endforelse
    </tbody>
</table>
{{ $lists->links() }}
</div>