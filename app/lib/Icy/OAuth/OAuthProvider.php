<?php namespace Icy\OAuth;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/21/2014
 * Time: 7:41 PM
 */

class OAuthProvider extends \Eloquent {

	protected $table = 'oauth_providers';

	protected $guarded = array('id');

	public function users()
	{
		return $this->belongsToMany('Icy\User\User');
	}

	public function oauthAccounts()
	{
		return $this->belongsToMany('Icy\OAuth\OAuthAccount');
	}

}