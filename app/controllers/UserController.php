<?php

use Icy\Favourite\IFavouriteRepository;
use Icy\Steam\ISteamService;
use Icy\User\IUserService;

class UserController extends Controller {

	/**
	 * @var IUserService
	 */
	private $userService;
	/**
	 * @var IFavouriteRepository
	 */
	private $favouriteRepository;
	/**
	 * @var ISteamService
	 */
	private $steamService;

	public function __construct(IUserService $userService, IFavouriteRepository $favouriteRepository, ISteamService $steamService)
	{
		$this->beforeFilter('auth', ['only' => ['profile']]);

		$this->userService = $userService;
		$this->favouriteRepository = $favouriteRepository;
		$this->steamService = $steamService;
	}

	public function profile()
	{
		return View::make('user.profile');
	}

	public function favourites()
	{
		// TODO: place authentication in our own service and remove dependency on eloquent
		$userId = Auth::id();

		$favourites = $this->steamService->attachPlayerProfiles($this->favouriteRepository->getAllByUserId($userId));

		// load steamids
		foreach ($favourites as &$favourite)
		{
			$favourite->steamId->text = $this->steamService->convert64ToText($favourite->steamId->steamid);
		}

		return View::make('user.favourites')
			->withFavourites($favourites);
	}

}
