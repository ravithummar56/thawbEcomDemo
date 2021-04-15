<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Redirect::to('admin');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

	Route::get('verify-email/{id}','Admin\AuthController@verifyEmail');

Route::group(['prefix'=>'admin','namespace' => 'Admin'], function() 
{
	Route::get('language/{locale}', function ($locale) {
				Config::set('app.locale', $locale);
				Session::put('locale',$locale);
				return back();
			});

	Route::get('/', function () {
		if (!Auth::check()) {
		    return Redirect::to('admin/login');
		} else {
		    return Redirect::to("admin/dashboard");
		}
	});

	Route::get('login','AuthController@loginView')->name('login');
	Route::post('login','AuthController@doLogin');
	Route::get('logout','AuthController@doLogout');
	Route::group(['middleware' => ['SetLocale','auth']], function() 
	{
		
		Route::get('dashboard','AuthController@dashboard'); 
		
		Route::resource('users','UserController');    
		
		Route::resource('shipping-charg','ShippingChargController');    
		
		Route::resource('product','ProductController'); 
			Route::GET('product/get-images/{id}','ProductController@getImage');  
			Route::GET('product/remove-images/{id}','ProductController@removeImage');  
		
		Route::resource('fabrics','FabricController');        
		Route::resource('kandora-style','KandoraStyleController');    
		Route::resource('collar-style','CollarStyleController');    
		
		Route::resource('color','ColorController');    
		Route::resource('kandora-price','KandoraPriceController');    
		Route::resource('request-trailer','RequestTrailerController');    
		
		Route::resource('size','SizeController');  
		Route::resource('promotion-code','PromotionCodeController');  

		Route::resource('order','OrderController');
		 	Route::POST('/payment-status','OrderController@changePaymentStatus'); 
          	Route::POST('/order-status','OrderController@changeOrderStatus');     
          	Route::GET('/change-delivery-date','OrderController@changeDeliveryDate');     
		
		Route::resource('status','StatusController');    
	});
});

