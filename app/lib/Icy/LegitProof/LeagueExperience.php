<?php namespace Icy\LegitProof;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 5:50 PM
 */

class LeagueExperience extends \Eloquent {

	protected $table = 'legitproof_crawl';

	public $timestamps = false;

	protected $guarded = ['id'];

} 