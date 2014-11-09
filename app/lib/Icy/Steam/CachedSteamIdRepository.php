<?php namespace Icy\Steam;
use Icy\Common\CachedRepository;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 11/7/2014
 * Time: 12:45 AM
 */

class CachedSteamIdRepository extends CachedRepository implements ISteamIdRepository {

	const STEAM_ID_DURATION = 60;

	/**
	 * @var ISteamIdRepository
	 */
	private $repository;

	public function __construct($cache, ISteamIdRepository $repository)
	{
		parent::__construct($cache);
		$this->repository = $repository;
	}

	public function getBySteamId($steamId)
	{
		return $this->cache()->remember('steamid_' . $steamId, self::STEAM_ID_DURATION, function () use ($steamId)
		{
			return $this->repository->getBySteamId($steamId);
		});
	}

	public function save(SteamId $steamId)
	{
		return $this->repository->save($steamId);
	}

}