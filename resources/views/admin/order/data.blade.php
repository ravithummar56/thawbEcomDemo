<div class="table-responsive">
<table width="100%" class="m-dt-table table table-bordered table-hover" id="html_table">
      <thead class="m-datatable__head">
          <tr class="m-datatable__row">
          <th><input class="select-all" type="checkbox"></th><th>{{trans('common.srno')}}</th>
          <th>{{trans('sidebar.order')}} {{trans('common.number')}}</th>
          <th>{{trans('common.date')}}</th>
          <th>{{trans('common.total')}}</th>
          <th>{{trans('sidebar.order')}} {{trans('common.status')}}</th>
          <th>{{trans('common.estimate_delivered_date')}}</th>
          <th>{{trans('common.payment')}} {{trans('common.type')}} 
            <!--begin: Dropdown-->
            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push float-right" m-dropdown-toggle="click" aria-expanded="true">
              <a href="#" class="m-portlet__nav-link m-dropdown__toggle ">
                <i class="fa fa-filter filter-data"></i>
              </a>
              <div class="m-dropdown__wrapper">
                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="right: auto; left: 29.5px;"></span>
                <div class="m-dropdown__inner">
                  <div class="m-dropdown__body">
                    <div class="m-dropdown__content">
                      <ul class="m-nav">
                        <li class="m-nav__section m-nav__section--first">
                          <span class="m-nav__section-text">
                            <b>{{trans('common.quickactions')}}</b>
                          </span>
                         <li class="m-nav__separator m-nav__separator--fit"></li>
                        </li>                          
                        <li class="m-nav__item">
                          <a  class="m-nav__link cod" style="color: #78797c; cursor: pointer;">
                             <p class="paymentType_cod" data-value = 'cod' ><i class="fa fa-chevron-right " ></i>&nbsp;cod</p>
                          </a>
                        </li>
                        <li class="m-nav__item">
                          <a  class="m-nav__link payfort" style="color: #78797c; cursor: pointer;">
                             <p class="paymentType_payfort" data-value = 'payfort'><i class="fa fa-chevron-right " ></i>&nbsp;payfort</p>
                          </a>
                        </li>                         
                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__item">
                          <a href="" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                            {{trans('common.cancel')}}
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--end: Dropdown-->
          </th>
          <th>{{trans('common.payment')}} {{trans('common.status')}} 
            <!--begin: Dropdown-->
            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push float-right" m-dropdown-toggle="click" aria-expanded="true">
              <a href="#" class="m-portlet__nav-link m-dropdown__toggle ">
                <i class="fa fa-filter filter-data"></i>
              </a>
              <div class="m-dropdown__wrapper">
                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="right: auto; left: 29.5px;"></span>
                <div class="m-dropdown__inner">
                  <div class="m-dropdown__body">
                    <div class="m-dropdown__content">
                      <ul class="m-nav">
                        <li class="m-nav__section m-nav__section--first">
                          <span class="m-nav__section-text">
                            <b>{{trans('common.quickactions')}}</b>
                          </span>
                         <li class="m-nav__separator m-nav__separator--fit"></li>
                        </li>
                          @foreach($payment_status as $key => $value)
                            <li class="m-nav__item">
                              <a class="m-nav__link" style="color: #78797c; cursor: pointer;">
                                 <p class="payment_status" id='payment_status{{$key}}' data-id="{{$key}}"><i class="fa fa-chevron-right "></i>&nbsp;{{trans('status.'.$value)}}</p>
                              </a>
                            </li>
                          @endforeach
                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__item">
                          <a href="" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                            {{trans('common.cancel')}}
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--end: Dropdown--> 
          </th>
          <th>{{trans('common.action')}} </th>
          </tr>
      </thead>
      <tbody class="m-datatable__body">
        @forelse($lists as $row)
          <tr class="m-datatable__row row-font-color">
          <td style="width: 2%;"><input name="di[]" type="checkbox" value="{{$row->id}}"></td>
         <td>&nbsp;&nbsp;{{ ($lists ->currentpage()-1) * $lists ->perpage() + $loop->index + 1 }}</td>
          <td>{{$row->order_id}}</td>
          <td>{{$row->orderDate}}</td>
          <td>AED {{$row->total}}</td>
          <td><span class="O_status" data-id = "{{$row->id}}">{{orderStatus($row->order_status_id)}}</span></td>
          <td><span >{{$row->delivered_date}}</span></td>
          <td><span class="req" data-id = "{{$row->id}}">{{$row->payments_type}}</span></td>
          <td><span class="p_status" data-id = "{{$row->id}}">{{paymentStatus($row->payments_status_id)}}</span></td>
          <td><a href="{{URL::to('admin/order/'.$row->order_id)}}" class="view-order"><i class="fa fa-eye"></i></a></td>
          </tr>
          @empty
          <tr class="odd gradeX">
                <td class="text-center" colspan="9"> No data found.....</td>
          </tr> 
      @endforelse
      </tbody>
  </table>
  </div>
  {{ $lists->links() }}
 