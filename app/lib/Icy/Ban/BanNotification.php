<?php namespace Icy\Ban;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 2:25 AM
 */

class BanNotification extends \Eloquent {

	protected $table = 'ban_notifications';

	protected $guarded = ['id'];

	protected $with = ['BanType'];

//	public function favourite()
//	{
//		return $this->belongsTo('Icy\Favourite\Favourite');
//	}

	public function banType()
	{
		return $this->hasOne('Icy\Ban\BanType', 'id', 'ban_type_id');
	}

} 