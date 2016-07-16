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

Route::post('auth/register','AdvReg@register');
 // такой маршрут  auth/register у нас уже есть в router.php, его надо изменить на этот
Route::get('register/confirm/{token}','AdvReg@confirm');

Route::auth();


Route::get('/home', 'HomeController@index');
