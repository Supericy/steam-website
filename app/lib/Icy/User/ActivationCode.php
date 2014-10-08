<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/27/2014
 * Time: 9:29 PM
 */

class ActivationCode extends \Eloquent {

	protected $table = 'activation_codes';

	protected $guarded = array('id');

	public function user()
	{
		return $this->belongsTo('Icy\User\User');
	}

} 