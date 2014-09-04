<?php namespace Icy\BanListener;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 7:16 PM
 */

class BanListener extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ban_listeners';

	protected $guarded = array('id');

	public function user()
	{
		return $this->belongsTo('Icy\User\User');
	}

	public function steamId()
	{
		return $this->belongsTo('Icy\Steam\SteamId', 'steamid_id');
	}

}