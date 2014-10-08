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
		return $this->model->where('steamid', $steamId)->first();
	}

	public function createMany(array $arrayOfValues)
	{
		$steamIds = [];

		foreach ($arrayOfValues as $values)
		{
			$steamIds[] = $this->firstOrCreate($values);
		}

		return $steamIds;
	}

//	public function firstOrCreateAndUpdateVacStatus(array $values)
//	{
//		$entry = $this->firstOrNew($values);
//
//		$newVacStatus = $this->steam->isVacBanned($entry->steamid);
//
//		if ($newVacStatus != $entry->vac_banned)
//		{
//			$entry->vac_banned = $newVacStatus;
//			$entry->changed = true;
//		}
//
//		$this->save($entry);
//
//		return $entry;
//	}

	public function firstOrNew(array $values)
	{
		return $this->model->firstOrNew($values);
	}

	public function firstOrCreate(array $values)
	{
		return $this->model->firstOrCreate($values);
	}

	public function create(array $values)
	{
		return $this->model->create($values);
	}

	public function save(SteamId $steamId)
	{
		return $steamId->save();
	}

	public function getAll()
	{
		return $this->model->all();
	}

}