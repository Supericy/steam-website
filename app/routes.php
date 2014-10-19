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

Route::get('/', [function ()
{
	return Redirect::action('search-steamid');
},
	'as' => 'home'
]);

Route::controller('tests', 'PlaygroundController');

//Route::get('/tests', array(
//	'uses' => 'PlaygroundController@tests',
//));

Route::get('/search', [
	'uses' => 'SteamIdController@searchSteamId',
	'as' => 'search-steamid'
]);

Route::get('/steamid/{id}', [
	'uses' => 'SteamIdController@display',
	'as' => 'steamid.display'
]);


Route::post('/steamid/bulk-create', [
	'uses' => 'SteamIdController@createSteamIdBulk'
]);

Route::get('/activate/{code}', [
	'uses' => 'RegisterController@activate',
	'as' => 'user.activate'
]);


/**
 * Follow and unfollow routes
 */
Route::get('/steamid/{id}/follow', [
	'uses' => 'FollowController@follow',
	'as' => 'steamid.follow'
]);

Route::get('/steamid/{id}/unfollow', [
	'uses' => 'FollowController@unfollow',
	'as' => 'steamid.unfollow'
]);



Route::group(['before' => 'guest'], function ()
{

	Route::get('/login', [
		'uses' => 'LoginController@getLogin',
		'as' => 'get.login'
	]);

	Route::get('login/oauth/{serviceProvider}', [
		'as' => 'login.oauth',
		'uses' => 'OAuthLoginController@login'
	]);

	// password recovery
	// TODO: implement
	Route::get('/blah', [
		'as' => 'login.recovery',
		function ()
		{
			return 'sux';
		}
	]);

	Route::group(['before', 'csrf'], function ()
	{
		Route::post('/login', [
			'uses' => 'LoginController@postLogin',
			'as' => 'post.login'
		]);

		Route::post('/register', [
			'uses' => 'RegisterController@postRegister',
			'as' => 'post.register'
		]);
	});


	Route::get('/register', [
		'uses' => 'RegisterController@getRegister',
		'as' => 'get.register'
	]);

});

Route::group(['before' => 'auth'], function ()
{

	Route::get('/logout', [
		'uses' => 'LoginController@logout',
		'as' => 'logout'
	]);

});



