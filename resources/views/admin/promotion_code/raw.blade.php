<div class="table-responsive">
    
<table width="100%" class="m-dt-table table table-bordered table-hover" id="html_table">
    <thead class="m-datatable__head">
        <tr class="m-datatable__row">
        <th>{{trans('common.srno')}}</th>
        <th>{{trans('promotion_code.title')}}</th>
        <th>{{trans('promotion_code.code')}}</th>
        <th>{{trans('promotion_code.limit')}}</th>
        <th>{{trans('promotion_code.start_date')}}</th>
        <th>{{trans('promotion_code.end_date')}}</th>
        <th>{{trans('common.action')}}</th>
        </tr>
    </thead>
    <tbody class="m-datatable__body">
        @forelse($lists as $row) 
            <tr class="m-datatable__row">
                <td>&nbsp;&nbsp;{{ ($lists ->currentpage()-1) * $lists ->perpage() + $loop->index + 1 }}</td>
                <td>{{$row->title}}</td>
                <td>{{$row->code}}</td>
                <td>{{$row->limit}}</td>
                <td>{{$row->start_date}}</td>
                <td>{{$row->end_date}}</td>
                <td><a href="{{ URL::to('admin/promotion-code/'.$row->id.'/edit') }}"><i class="fa fa-pencil"></i></a> &nbsp; <a href="#" class="delete-user" data-id="{{$row->id}}"> <i class="fa fa-times-circle-o"></i></a></td>
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