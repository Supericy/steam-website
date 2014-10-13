<?php namespace Icy\BanNotification;

class BanNotificationRepository implements IBanNotificationRepository {

	private $model;
	private $banTypeRepository;

	public function __construct(BanNotification $model, \Icy\BanDetection\IBanTypeRepository $banTypeRepository)
	{
		$this->model = $model;
		$this->banTypeRepository = $banTypeRepository;
	}

	public function create(array $values)
	{
		return $this->model->create($values);
	}

	public function createMany(array $arrayOfValues)
	{
		$objects = [];

		foreach ($arrayOfValues as $values)
		{
			$objects[] = $this->create($values);
		}

		return $objects;
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
				'enabled' => true,
			];
		}

		return $this->createMany($arrayOfValues);
	}

	public function getByFavouriteId($favouriteId)
	{
		return $this->model->where('favourite_id', $favouriteId);
	}

	public function getByFavouriteIdAndBanName($favouriteId, $banName)
	{
		$banType = $this->banTypeRepository->getByName($banName);

		return $this->getByFavouriteIdAndBanTypeId($favouriteId, $banType->id);
	}

	public function getByFavouriteIdAndBanTypeId($favouriteId, $banTypeId)
	{
		return $this->model
			->where('favourite_id', $favouriteId)
			->where('ban_type_id', $banTypeId);
	}

	public function save(BanNotification $banNotification)
	{
		return $banNotification->save();
	}

} 