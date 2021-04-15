 <!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
			{{trans('login.signin')}} | {{config('admin.project_name')}}
		</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--begin::Base Styles -->
		<link href="{{URL::to('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{URL::to('public/assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="{{ URL::to('public/default/favicon.ico')}}" />
	</head>
	<!-- end::Head -->
    <!-- end::Body -->
	<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(public/assets/app/media/img//bg/bg-3.jpg);">
				<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo mb-0">
							<a href="#">
								
										<img src="{{URL::to('public/default/logo.png')}}" width="80%">
							</a>
						</div>
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">
									{{trans('login.signinAdmin')}}
								</h3>
							</div>
							{{Form::open(['url' => 'admin/login','method' => 'post','class' => 'm-login__form m-form','id' => 'user_login'])}}
							
								<div class="form-group m-form__group">
									{{Form::text('email','',array('class'=>'form-control m-input','placeholder'=>trans("login.email"),'autocomplete'=>'off'))}}
									
								</div>
								<div class="form-group m-form__group">
									{{Form::password('password',array('class'=>'form-control m-input m-login__form-input--last','placeholder'=>trans("login.password")))}}
								</div>
								<div class="row m-login__form-sub">
									<!-- <div class="col m--align-left m-login__form-left">
										<label class="m-checkbox  m-checkbox--focus">
											
											{{Form::checkbox('remember')}}Remember me
											<span></span>
										</label>
									</div> -->
									{{-- <div class="col m--align-right m-login__form-right">
										<a href="javascript:;" id="m_login_forget_password" class="m-link">
											Forget Password ?
										</a>
									</div> --}}
								</div>
								<div class="m-login__form-action">
									{{Form::submit(trans('login.signin'),array('id'=>'btn_login','class'=>'btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary'))}}
								</div>
							{{Form::close()}}
						</div>
						<div class="m-login__signup">
							<div class="m-login__head">
								<h3 class="m-login__title">
									Sign Up
								</h3>
								<div class="m-login__desc">
									Enter your details to create your account:
								</div>
							</div>
							{{Form::open(['url' => '','method' => 'post','class' => 'm-login__form m-form','id'=>'user_register'])}}
								<div class="form-group m-form__group">
									{{Form::text('name','',array('class'=>'form-control m-input','placeholder'=>'name','autocomplete'=>'off'))}}
								</div>
								<div class="form-group m-form__group">
									{{Form::email('email','',array('class'=>'form-control m-input','placeholder'=>'email','autocomplete'=>'off'))}}
								</div>
								<div class="form-group m-form__group">
									{{Form::password('password',array('class'=>'form-control m-input','placeholder'=>'password','autocomplete'=>'off'))}}
								</div>
								<div class="form-group m-form__group">
									{{Form::password('password_confirmation',array('class'=>'form-control m-input','placeholder'=>'Confirm Password','autocomplete'=>'off'))}}
								</div>
								<div class="row form-group m-form__group m-login__form-sub">
									<div class="col m--align-left">
										<label class="m-checkbox m-checkbox--focus">
											{{Form::checkbox('agree')}}
											I Agree the
											<a href="#" class="m-link m-link--focus">
												terms and conditions
											</a>
											.
											<span></span>
										</label>
										<span class="m-form__help"></span>
									</div>
								</div>
								<div class="m-login__form-action">
									{{Form::submit('Sign Up',array('id'=>'btn_signup','class'=>'btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn'))}}
									
									&nbsp;&nbsp;
									{{Form::button('Cancel',array('id'=>'m_login_signup_cancel','class'=>'btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn'))}}
									
								</div>
							</form>
						</div>
						<div class="m-login__forget-password">
							<div class="m-login__head">
								<h3 class="m-login__title">
									Forgotten Password ?
								</h3>
								<div class="m-login__desc">
									Enter your email to reset your password:
								</div>
							</div>
							{{Form::open(['url' => 'admin/forgot-password','method' => 'post','class' => 'm-login__form m-form'])}}
								<div class="form-group m-form__group">
									{{Form::email('email','',array('id'=>'m_email','class'=>'form-control m-input','placeholder'=>'Email','autocomplete'=>'off'))}}
									
								</div>
								<div class="m-login__form-action">
									{{Form::button('Sign Up',array('id'=>'m_login_forget_password_submit','class'=>'btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn'))}}
									&nbsp;&nbsp;
									{{Form::button('Cancel',array('id'=>'m_login_forget_password_cancel','class'=>'btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn'))}}
								</div>
							</form>
						</div>
						<div class="m-login__account">
						</div>
					</div>
				</div>
					<div class="text-right mr-4" style="font-size: 200%;">
						<a href="{{URL::to('admin/language/en')}}" style="text-decoration-line: none;"><b>EN</b></a> | <a href="{{URL::to('admin/language/es')}}" style="text-decoration-line: none;"><b>ES</b></a>  
					</div>
			</div>
		</div>
		<!-- end:: Page -->
    	<!--begin::Base Scripts -->
		<script src="{{URL::to('public/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{URL::to('public/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
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
		<!--end::Base Scripts -->   
        <!--begin::Page Snippets -->
		<script src="{{URL::to('public/assets/snippets/custom/pages/user/login.js')}}" type="text/javascript"></script>
		<script>
			$(document).ready(function() {
				var n = function(e, i, a) {
		            var l = $('<div class="m-alert m-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
		            e.find(".alert").remove(), l.prependTo(e), mUtil.animateClass(l[0], "fadeIn animated"), l.find("span").html(a)
		        }
		        //Login
				$(document).on('submit', '#user_login', function(event) {
					event.preventDefault();
					var form=$(this);
					var btn=$("#btn_login");
					form.validate({
				        rules: {
				            email: {
				                required: !0,
				                email: !0
				            },
				            password: {
				                required: !0
				            }
				        }
				    });
				    if(form.valid()){
				    	btn.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0);
				    	$.ajax({
				    		url: "{{url('admin/login')}}",
				    		type: 'post',
				    		dataType: 'json',
				    		data: form.serialize(),
				    	})
				    	.done(function(response) {
				    		if(response.status){
				    			n(form, "success", "{{trans('login.success')}}");
				    			window.location.href="{{url('admin/dashboard')}}";
				    		}else{
				    			n(form, "danger", "{{trans('login.loginValidation2')}}")
				    		}
				    	})
				    	.fail(function() {
				    		n(form, "danger", "{{trans('login.somethingWrong')}}")
				    	})
				    	.always(function() {
				    		btn.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1);
				    	});
				    	
				    }
				});
				//Resigster
				$(document).on('submit', '#user_register', function(event) {
					event.preventDefault();
					var form=$(this);
					var btn=$("#btn_signup");
					
					form.validate({
                    rules: {
	                        name: {
	                            required: !0
	                        },
	                        email: {
	                            required: !0,
	                            email: !0
	                        },
	                        password: {
	                            required: !0
	                        },
	                        password_confirmation: {
	                            required: !0
	                        },
	                        agree: {
	                            required: !0
	                        }
	                    }
	                });
	                if(form.valid()){
	                	btn.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0);
	                	$.ajax({
							url: "{{url('admin/register')}}",
							type: 'post',
							dataType: 'json',
							data: form.serialize(),
						})
						.done(function(response) {
						if(typeof response!="undefined"){
								var cls='';
								var message='';
								if(response.status){
									cls='success';
									message=response.msg;
									form.trigger('reset');
								}else{
									cls='danger';
									message=response.msg;
								}
								n(form, cls, message);
							}
						})
						.fail(function() {
							n(form, "danger", "Something went wrong");
						})
						.always(function() {
							btn.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1);
						});
	                }
				});
			});
		</script>
		<!--end::Page Snippets -->
	</body>
	<!-- end::Body -->
</html>
