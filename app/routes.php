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
    'uses' => 'HomeController@showWelcome',
    'as' => 'home'
));

Route::get('/blah', array(
    'as' => 'login.recovery',
    function () {
        return 'sux';
    }
));


Route::group(array('before' => 'guest'), function () {

    Route::group(array('before', 'csrf'), function () {
        Route::post('/login', array(
            'uses' => 'LoginController@postLogin',
            'as' => 'post.login'
        ));

        Route::post('/register', array(
            'uses' => 'RegisterController@postRegister',
            'as' => 'post.register'
        ));
    });

    Route::get('/login', array(
        'uses' => 'LoginController@getLogin',
        'as' => 'get.login'
    ));

    Route::get('/register', array(
        'uses' => 'RegisterController@getRegister',
        'as' => 'get.register'
    ));

});



