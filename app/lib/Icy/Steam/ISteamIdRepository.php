<?php namespace Icy\Steam;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/31/14
 * Time: 5:49 AM
 */

interface ISteamIdRepository {

	public function getBySteamId($steamId);

	public function createMany(array $arrayOfValues);

	public function firstOrCreateAndUpdateVacStatus(array $values);

	public function firstOrCreate(array $values);

	public function firstOrNew(array $values);

	public function create(array $values);

	public function save(SteamId $steamId);

	public function all();

}