<?php

use Icy\Favourite\IFavouriteService;
use Icy\User\IUserService;

class ProfileController extends Controller {

	/**
	 * @var IUserService
	 */
	private $userService;
	/**
	 * @var \Icy\Favourite\FavouriteService
	 */
	private $favouriteService;

	public function __construct(IUserService $userService, IFavouriteService $favouriteService)
	{
		$this->userService = $userService;
		$this->favouriteService = $favouriteService;

		$this->beforeFilter('auth', ['only' => ['profile']]);
	}

	public function profile()
	{
		return View::make('user.profile');
	}

	public function favourites()
	{
		// TODO: place authentication in our own service and remove dependency on eloquent
		$userId = Auth::id();

		$favourites = $this->favouriteService->getAllFavourites($userId, true);

		return View::make('user.favourites')
			->withFavourites($favourites);
	}

}
