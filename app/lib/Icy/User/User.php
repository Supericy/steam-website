<?php namespace Icy\User;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

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
	protected $hidden = array('password');

    protected $guarded = array('id');

	public function oauthAccounts()
	{
		return $this->hasMany('Icy\OAuth\OAuthAccount');
	}

	public function oauthProviders()
	{
		return $this->hasManyThrough('Icy\OAuth\OAuthProvider', 'Icy\OAuth\OAuthAccount', 'user_id', 'id');
	}

	public function banListeners()
	{
		return $this->hasMany('Icy\BanListener\BanListener');
	}

	public function authTokens()
	{
		return $this->hasMany('Icy\User\AuthToken');
	}

	public function hasPassword()
	{
		return $this->password !== null;
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
