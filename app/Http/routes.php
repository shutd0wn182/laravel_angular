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

Route::get('/', 'Home\HomeController@index');

Route::get('/gettoken/', 'Home\HomeController@get_token');

Route::get('/getfilms/', 'Home\HomeController@get_films');

Route::get('/getlastfilm/', 'Home\HomeController@get_last_film');

Route::post('/addfilm/', 'Home\HomeController@add_film');
