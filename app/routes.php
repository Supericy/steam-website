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

Route::get('/info', function ()
{
	phpinfo();
});

Route::controller('tests', 'PlaygroundController');

Route::get('/', [function ()
{
	return Redirect::action('search-steamid');
},
	'as' => 'home'
]);


Route::get('/profile', [
	'uses' => 'ProfileController@profile',
	'as' => 'profile'
]);

Route::get('/profile/favourites', [
	'uses' => 'ProfileController@favourites',
	'as' => 'profile.favourites',
]);



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

/**
 * Follow and unfollow routes
 */
Route::get('/steamid/{id}/follow', [
	'uses' => 'FavouriteController@favourite',
	'as' => 'steamid.follow'
]);
Route::get('/steamid/{id}/unfollow', [
	'uses' => 'FavouriteController@unfavourite',
	'as' => 'steamid.unfollow'
]);



Route::get('/register', [
	'uses' => 'RegisterController@getRegister',
	'as' => 'get.register'
]);
Route::post('/register', [
	'uses' => 'RegisterController@postRegister',
	'as' => 'post.register'
]);
Route::get('/activate/{code}', [
	'uses' => 'RegisterController@activate',
	'as' => 'user.activate'
]);


Route::get('/login/recovery', [function ()
	{
		return HTML::link(URL::to('/search'));
	},
	'as' => 'login.recovery'
]);


Route::get('/login', [
	'uses' => 'LoginController@getLogin',
	'as' => 'get.login'
]);
Route::post('/login', [
	'uses' => 'LoginController@postLogin',
	'as' => 'post.login'
]);


Route::get('login/oauth/{serviceProvider}', [
	'uses' => 'OAuthLoginController@login',
	'as' => 'login.oauth'
]);


Route::get('/logout', [
	'uses' => 'LoginController@logout',
	'as' => 'logout'
]);