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

 Route::post('/ajax',function(){
 	return "hello guys";
 });




//sitemap begins here

 Route::get('sitemap', function(){

    // create new sitemap object
    $sitemap = App::make("sitemap");

    
    // by default cache is disabled

    //allow the application to  cache for over 60 minutes
    $sitemap->setCache('laravel.sitemap', 60);
    
    // check if there is cached sitemap and build new only if it is not
    if (!$sitemap->isCached())
    {
         // add item to the sitemap (url, date, priority, freq)
         $sitemap->add(URL::to('/'), '2012-08-25T20:10:00+02:00', '1.0', 'daily');
         $sitemap->add(URL::to('profile'), '2012-08-26T12:30:00+02:00', '0.9', 'weekly');
         $sitemap->add(URL::to('register'), '2012-08-26T12:30:00+02:00', '0.9', 'daily');
         $sitemap->add(URL::to('login'), '2012-08-26T12:30:00+02:00', '0.9', 'weekly');
         $sitemap->add(URL::to('logout'), '2012-08-26T12:30:00+02:00', '0.9', 'daily');
         $sitemap->add(URL::to('notification'), '2012-08-26T12:30:00+02:00', '0.9', 'daily');
         $sitemap->add(URL::to('ajax'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
         $sitemap->add(URL::to('home'), '2012-08-26T12:30:00+02:00', '0.9', 'daily');



        

        
    }

    // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
    return $sitemap->render('xml');

});
