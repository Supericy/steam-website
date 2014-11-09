<?php namespace Icy\Steam;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/31/14
 * Time: 5:49 AM
 */

interface ISteamIdRepository {

	public function getBySteamId($steamId);

	public function save(SteamId $steamId);

}