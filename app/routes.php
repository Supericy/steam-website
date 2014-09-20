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



//Route::get('/', array(
//    'uses' => 'HomeController@showWelcome',
//    'as' => 'home'
//));

Route::get('/', array(function () {
	return Redirect::action('search-steamid');
},
	'as' => 'home'
));

Route::get('/tests', array(
	'uses' => 'PlaygroundController@tests',
));

Route::get('/search', array(
	'uses' => 'SteamIdController@searchSteamId',
	'as' => 'search-steamid'
));

Route::get('/steamid/{id}', array(
	'uses' => 'SteamIdController@display',
	'as' => 'steamid.display'
));

Route::get('/steamid/{id}/follow', array(
	'uses' => 'SteamIdController@createBanListener',
	'as' => 'steamid.follow'
));

Route::get('/steamid/{id}/unfollow', array(function () {
	return 'not implemeneted';
},
	'as' => 'steamid.unfollow'
));

Route::post('/steamid/create', array(
	'uses' => 'SteamIdController@createSteamId',
	'as' => 'steamid.create'
));

Route::post('/steamid/bulk-create', array(
	'uses' => 'SteamIdController@createSteamIdBulk'
));


Route::group(array('before' => 'guest'), function () {

	// password recovery
	// TODO: implement
	Route::get('/blah', array(
		'as' => 'login.recovery',
		function () {
			return 'sux';
		}
	));

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

Route::group(array('before' => 'auth'), function () {

    Route::get('/logout', array(
       'uses' => 'LoginController@logout',
        'as' => 'logout'
    ));

});



