<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/20/2014
 * Time: 5:18 PM
 */

class AuthToken extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'auth_tokens';

	protected $guarded = array('id');

	public function user()
	{
		return $this->belongsTo('Icy\User\User');
	}

}