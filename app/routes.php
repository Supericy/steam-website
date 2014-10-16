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
//    'uses' => 'SteamIdController@searchSteamId',
//    'as' => 'home'
//));

Route::get('/', array(function () {
	return Redirect::action('search-steamid');
},
	'as' => 'home'
));

Route::controller('tests', 'PlaygroundController');

//Route::get('/tests', array(
//	'uses' => 'PlaygroundController@tests',
//));

Route::get('/search', array(
	'uses' => 'SteamIdController@searchSteamId',
	'as' => 'search-steamid'
));

Route::get('/steamid/{id}', array(
	'uses' => 'SteamIdController@display',
	'as' => 'steamid.display'
));


Route::post('/steamid/bulk-create', array(
	'uses' => 'SteamIdController@createSteamIdBulk'
));

Route::get('/activate/{code}', array(
	'uses' => 'RegisterController@activate',
	'as' => 'user.activate'
));

Route::group(array('before' => 'auth'), function () {

	Route::get('/profile', array(
		'uses' => 'UserController@index'
	));

	Route::get('/steamid/{id}/follow', array(
		'uses' => 'FollowController@follow',
		'as' => 'steamid.follow'
	));

	Route::get('/steamid/{id}/unfollow', array(
		'uses' => 'FollowController@unfollow',
		'as' => 'steamid.unfollow'
	));

});

Route::group(array('before' => 'guest'), function () {

	Route::get('/login', array(
		'uses' => 'LoginController@getLogin',
		'as' => 'get.login'
	));

	Route::get('login/oauth/{serviceProvider}', array(
		'as' => 'login.oauth',
		'uses' => 'OAuthLoginController@login'
	));

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



