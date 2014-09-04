<?php namespace Icy\BanDetection;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 9:22 AM
 */

class BanDetection extends \Eloquent {

	protected $table = 'ban_detections';

	protected $guarded = ['id'];

	public function steamId()
	{
		return $this->belongsTo('Icy\Steam\SteamId', 'steamid_id');
	}

}