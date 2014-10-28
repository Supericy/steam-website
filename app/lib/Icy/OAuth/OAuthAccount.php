<?php namespace Icy\OAuth;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/21/2014
 * Time: 7:41 PM
 */

class OAuthAccount extends \Eloquent {

	protected $table = 'oauth_accounts';

	protected $guarded = ['id'];

	public function user()
	{
		return $this->belongsTo('Icy\User\User');
	}

	public function oauthProvider()
	{
		return $this->hasOne('Icy\OAuth\OAuthProvider', 'id', 'provider_id');
	}

}