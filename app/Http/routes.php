<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
		
	//$img->move(public_path('images/avatar'));
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/notification', 'NotificationController@index');
Route::get('/notification/delete/{notif}', 'NotificationController@destroy');
Route::get('profile','FormController@showForm');
 Route::post('profile','FormController@ajaxImagePost');

 //testing a jax form submission
 Route::get('/ajax','FormController@ajaxform');

 // Route::post('/ajax',function(){
 // 	return Request;
 // })
 Route::post('/ajax',function(){
 	return "hello guys";
 });

