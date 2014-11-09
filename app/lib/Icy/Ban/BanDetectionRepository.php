<?php namespace Icy\Ban;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 4:37 PM
 */

class BanDetectionRepository implements IBanDetectionRepository {

	private $model;
	/**
	 * @var BanTypeRepository
	 */
	private $banTypeRepository;

	public function __construct(BanDetection $model, BanTypeRepository $banTypeRepository)
	{
		$this->model = $model;
		$this->banTypeRepository = $banTypeRepository;
	}

	public function newDetection($steamIdId, $banName, $isBanned)
	{
		$banType = $this->banTypeRepository->getByName($banName);
		$banTypeId = $banType->id;

		return $this->model->create([
			'steamid_id' => $steamIdId,
			'ban_type_id' => $banTypeId,
			'ban_status' => $isBanned,
		]);
	}

}