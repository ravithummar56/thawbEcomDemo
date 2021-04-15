@extends('layouts.admin')
@section('title')
Dashboard
@endsection

@section('pagelevel_css')
<link href="{{URL::to('/css/custom.style.css')}}" rel="stylesheet" type="text/css">
    <style type="text/css">
        .m-body .m-content {
     padding: 0px 0px; 
}  
.pieLabel div {
  font-size: small !important;
}
    </style>
    @endsection
@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('sidebar.dashboard')}}
                    </h3>
                </div>
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                </div>
            </div>            
        </div>
    </div>
</link>
@endsection

@section('pagelevel_script')

@endsection
