<?php namespace Icy\User;

use Illuminate\Auth\UserInterface;

class User extends \Eloquent implements UserInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password'];

	protected $guarded = ['id'];

	protected $with = ['favourites'];

	public function favourites()
	{
		return $this->hasMany('Icy\Favourite\Favourite');
	}

	public function activationCode()
	{
		return $this->hasOne('Icy\User\ActivationCode');
	}

	public function oauthAccounts()
	{
		return $this->hasMany('Icy\OAuth\OAuthAccount');
	}

	public function oauthProviders()
	{
		return $this->hasManyThrough('Icy\OAuth\OAuthProvider', 'Icy\OAuth\OAuthAccount', 'user_id', 'id');
	}

	public function authTokens()
	{
		return $this->hasMany('Icy\User\AuthToken');
	}

	public function hasPassword()
	{
		return $this->password !== null;
	}

	public function isActive()
	{
		return $this->active;
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->id;
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return "remember_token";
	}
}
