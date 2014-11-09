<?php namespace Icy\Steam;

class SteamIdRepository implements ISteamIdRepository {

	private $model;
	private $steam;

	public function __construct(SteamId $model, ISteamService $steam)
	{
		$this->model = $model;
		$this->steam = $steam;
	}

	public function getBySteamId($steamId)
	{
//		$record = $this->model
//			->where('steamids.steamid', $steamId)
//			->join('esea_bans', 'steamids.steamid', '=', 'esea_bans.steamid')
//			->first();

		$record = $this->model->firstOrCreate(['steamid' => $steamId]);

//		$record->load('eseaBan');

		return $record;
	}

	public function save(SteamId $steamId)
	{
		return $steamId->save();
	}

}