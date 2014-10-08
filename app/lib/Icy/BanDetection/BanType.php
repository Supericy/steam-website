<?php namespace Icy\BanDetection;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/5/2014
 * Time: 11:44 PM
 */

class BanType extends \Eloquent {

	protected $table = 'ban_types';

	protected $guarded = ['id'];

	public function banDetections()
	{
		return $this->belongsToMany('Icy\BanDetection\BanDetection');
	}

}