<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('ok','HomeController@test');
Route::group(['prefix' => 'v1','namespace' => 'Api','middleware'=>'apiSetLang'], function() {
	
	Route::POST('login','AuthController@login');
	Route::POST('login-device','AuthController@loginDevice');
	Route::POST('signup','AuthController@signup');
	Route::POST('social-login','AuthController@socialLogin');		
	Route::POST('get-product','HomeController@getProduct');
	Route::GET('get-color','HomeController@getColor');
	Route::GET('get-fabric','HomeController@getFabric');

	Route::GET('get-state','HomeController@getState');
	Route::GET('get-collar-sleeve-style','HomeController@getCollerSleeveStyle');
	Route::GET('get-kandora-style','HomeController@getKandoraStyle');

	Route::group(['middleware' => 'authDeviceApi'], function(){
		Route::POST('show-cart','CartController@getCart');
		Route::POST('add-to-cart','CartController@addToCart');
		Route::POST('make-product','CartController@makeProduct');
		Route::POST('update-cart','CartController@updateCart');
		Route::POST('get-sizes','HomeController@getUserSizes');
		Route::POST('request-tailor','HomeController@requestTailor');
		Route::POST('save-saizes','HomeController@storeUserSizes');
	});
	
	Route::group(['middleware' => 'authApi'], function(){
		Route::POST('logout','AuthController@logout');

		Route::POST('get-profile','AuthController@getProfile');
		Route::POST('update-profile','AuthController@updateProfile');

		Route::POST('get-card','HomeController@getCard');
		Route::POST('save-card','HomeController@saveCard');
		Route::GET('edit-card/{id}','HomeController@editCard');
		Route::PUT('update-card/{id}','HomeController@updateCard');
		Route::GET('delete-card/{id}','HomeController@deleteCard');

		Route::POST('get-address','HomeController@getAddress');
		Route::POST('save-address','HomeController@saveAddress');
		Route::GET('edit-address/{id}','HomeController@editAddress');
		Route::PUT('update-address/{id}','HomeController@updateAddress');
		Route::GET('delete-address/{id}','HomeController@deleteAddress');

		Route::POST('checkout','OrderController@checkout');

		Route::POST('my-orders','OrderController@myOrders');
		Route::GET('my-order/{id}','OrderController@myOrder');



	});
});
