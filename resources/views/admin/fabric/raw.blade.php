<div class="table-responsive">
    
<table width="100%" class="m-dt-table table table-bordered table-hover" id="html_table">
    <thead class="m-datatable__head">
        <tr class="m-datatable__row">
        <th>{{trans('common.srno')}}</th>
        <th>{{trans('sidebar.fabric')}} {{trans('user.name')}} </th>
        <th>{{trans('common.image')}} </th>
        <th>{{trans('common.male')}} </th>
        <th>{{trans('common.female')}} </th>
        <th>{{trans('common.status')}} </th>
        <th>{{trans('common.action')}}</th>
        </tr>
    </thead>
    <tbody class="m-datatable__body">
        @forelse($lists as $row) 
            <tr class="m-datatable__row">
                <td>&nbsp;&nbsp;{{ ($lists ->currentpage()-1) * $lists ->perpage() + $loop->index + 1 }}</td>
                <td>{{$row->fabric_name}}</td>
                <td><img src="{{URL::to('public'.config('admin.image.fabric').$row->image)}}"  width="15%" height="15%"></td>  
               
                <td>{{ucfirst($row->male == "" ? '' : trans('common.'.$row->male))}}</td>
                <td>{{ucfirst($row->female == "" ? '' : trans('common.'.$row->female))}}</td>
                <td>{{ucfirst(trans('common.'.$row->status))}}</td>
                <td><a href="{{ URL::to('admin/fabrics/'.$row->id.'/edit') }}"><i class="fa fa-pencil"></i></a> &nbsp; <a href="#" class="delete" data-id="{{$row->id}}"> <i class="fa fa-times-circle-o"></i></a></td>                                          
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