<div class="table-responsive">
    
<table width="100%" class="m-dt-table table table-bordered table-hover" id="html_table">
    <thead class="m-datatable__head">
        <tr class="m-datatable__row">
        <th>{{trans('common.srno')}}</th>
        <th>{{trans('sidebar.size')}} {{trans('user.name')}} </th>
        <th>{{trans('product.slug')}} </th>
        <th>{{trans('product.mrp')}} </th>
        <th>{{trans('product.price')}}  </th>
        <th>{{trans('product.sell')}} {{trans('product.price')}}</th>
        <th>{{trans('common.gender')}} </th>
        <th>{{trans('common.type')}} </th>
        <th>{{trans('product.stock')}} </th>
        <th>{{trans('common.status')}} </th>
        <th>{{trans('common.action')}} </th>
        </tr>
    </thead>
    <tbody class="m-datatable__body">
        @forelse($lists as $row) 
            <tr class="m-datatable__row">
                <td>&nbsp;&nbsp;{{ ($lists ->currentpage()-1) * $lists ->perpage() + $loop->index + 1 }}</td>
                <td>{{$row->product_name}}</td>
                <td>{{$row->slug}}</td>
                <td>AED {{$row->manufacturing_price}}</td>
                <td>AED {{$row->price}}</td>
                <td>AED {{$row->sell_price}}</td>
                <td>{{ucfirst(trans('common.'.$row->gender))}}</td>
                <td>{{$row->type}}</td>
                <td>{{$row->quantity}}</td>
                <td>{{ucfirst(trans('common.'.$row->status))}}</td>
                <td><a href="{{ URL::to('admin/product/'.$row->id.'/edit') }}"><i class="fa fa-pencil"></i></a> &nbsp; <a href="#" class="delete" data-id="{{$row->id}}"> <i class="fa fa-times-circle-o"></i></a></td>                                          
            </tr>
        @empty
        <tr class="odd gradeX">
            <td class="text-center" colspan="9">{{trans('common.noData')}}</td>
        </tr> 
        @endforelse
    </tbody>
</table>
{{ $lists->links() }}
</div>