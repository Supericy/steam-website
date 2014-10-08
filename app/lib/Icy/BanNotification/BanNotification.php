<?php namespace Icy\BanNotification;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 2:25 AM
 */

class BanNotification extends \Eloquent {

	protected $table = 'ban_notifications';

	protected $guarded = ['id'];

	public function favourite()
	{
		return $this->belongsTo('Icy\Favourite\Favourite');
	}

} 