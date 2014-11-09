<?php namespace Icy\Ban;

class BanNotificationRepository implements IBanNotificationRepository {

	private $model;
	private $banTypeRepository;

	public function __construct(BanNotification $model, IBanTypeRepository $banTypeRepository)
	{
		$this->model = $model;
		$this->banTypeRepository = $banTypeRepository;
	}

	public function createForAllBanTypes($favouriteId)
	{
		$banTypes = $this->banTypeRepository->getAll();

		$arrayOfValues = [];

		foreach ($banTypes as $banType)
		{
			$arrayOfValues[] = [
				'favourite_id' => $favouriteId,
				'ban_type_id' => $banType->id,

				// enabled by default
				'enabled' => true,
			];
		}

		return $this->createMany($arrayOfValues);
	}

	public function enableNotification($favouriteId, $banName)
	{
		return $this->toggleNotification($favouriteId, $banName, true);
	}

	public function disableNotification($favouriteId, $banName)
	{
		return $this->toggleNotification($favouriteId, $banName, false);
	}

	public function toggleNotification($favouriteId, $banName, $enabled)
	{
		$record = $this->getByFavouriteIdAndBanName($favouriteId, $banName);

		$record->enabled = $enabled;
		return $this->save($record);
	}

	public function save(BanNotification $banNotification)
	{
		return $banNotification->save();
	}

	private function createMany(array $arrayOfValues)
	{
		$objects = [];

		foreach ($arrayOfValues as $values)
		{
			$objects[] = $this->model->firstOrCreate($values);
		}

		return $objects;
	}

	private function getByFavouriteIdAndBanName($favouriteId, $banName)
	{
		$banTypeRecord = $this->banTypeRepository->getByName($banName);

		return $this->model
			->where('favourite_id', $favouriteId)
			->where('ban_type_id', $banTypeRecord->id);
	}

} 