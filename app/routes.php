<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
    "uses" => "HomeController@showWelcome"
));

Route::get('/login', array(
    "uses" => "HomeController@showWelcome"
));

Route::match(array('GET'), '/register', array(
    "uses" => "RegisterController@getRegister"
));

Route::match(array('POST'), '/register', array(
    "uses" => "RegisterController@postRegister"
));