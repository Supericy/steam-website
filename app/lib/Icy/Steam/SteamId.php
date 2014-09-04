<?php namespace Icy\Steam;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/28/14
 * Time: 5:13 AM
 */

class SteamId extends \Eloquent {

    protected $table = 'steamids';

	protected $guarded = array('id');

	public function banListeners()
	{
		return $this->hasMany('Icy\BanListener\BanListener', 'steamid_id');
	}

	public function banDetections()
	{
		return $this->hasMany('Icy\BanDetection\BanDetection', 'steamid_id');
	}

}