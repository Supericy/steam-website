<?php namespace Icy\Favourite;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 12:45 AM
 */

class Favourite extends \Eloquent {

	protected $table = 'favourites';

	protected $guarded = ['id'];

	protected $with = ['steamId', 'banNotifications'];

	public function user()
	{
		return $this->belongsTo('Icy\User\User');
	}

	public function banNotifications()
	{
		return $this->hasMany('Icy\Ban\BanNotification');
	}

	public function steamId()
	{
		return $this->belongsTo('Icy\Steam\SteamId', 'steamid_id');
	}

	public function getUserId()
	{
		return $this->userid;
	}

	public function getSteamIdId()
	{
		return $this->steamid_id;
	}

} 