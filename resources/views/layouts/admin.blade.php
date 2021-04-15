<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title> {{config('admin.project_name')}} | @yield('title')   </title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->
        <!--begin::Base Styles -->  
		<link href="{{ URL::to('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ URL::to('public/assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="{{ URL::to('public/default/favicon.ico')}}" />
        @yield('pagelevel_css')

	</head>
	<!-- end::Head -->
    <!-- end::Body -->
	<body  class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"   >
		<!-- begin:: Page -->
		
        <div class="m-grid m-grid--hor m-grid--root m-page">
			<!--begin::header  -->
			@include('includes.admin.header')
			<!-- end::header -->
			
			<!--begin::sidebar  -->
			@include('includes.admin.sidebar')
			<!-- end::sidebar -->

			<!--begin::content part  -->
				@yield('content')
			<!-- end::content part -->
        </div>

			<!--begin::footer  -->
            @include('includes.admin.footer')

            <input id="baseUrl" value="{{URL::to('/')}}" type="hidden">
			<!-- end::footer -->

 			<!-- BEGIN PAGE LEVEL PLUGINS -->
 				@yield('pagelevel_plugins') 
        	<!-- END PAGE LEVEL PLUGINS -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script> -->
		<script src="{{ URL::to('public/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
		<script src="{{ URL::to('public/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
		<!--end::Base Scripts -->   
        <script src="{{ URL::to('public/js/custom.js')}}" type="text/javascript"></script>
        <!--begin::Page Snippets -->
		<script type="text/javascript">
			$(document).ready(function(){
				var baseUrl = $('#baseUrl').val();
			});
		</script>
		<!--end::Page Snippets -->
		@yield('pagelevel_script')
	</body>
	<!-- end::Body -->
</html>