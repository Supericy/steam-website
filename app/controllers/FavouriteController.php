<?php
use Icy\Authentication\IAuthenticationService;
use Icy\Favourite\IFavouriteService;
use Icy\IBanService;
use Icy\Steam\ISteamService;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/15/2014
 * Time: 9:49 PM
 */
class FavouriteController extends Controller {

	/**
	 * @var \Icy\IBanService
	 */
	private $banService;
	/**
	 * @var \Icy\IFavouriteService
	 */
	private $favouriteService;
	/**
	 * @var \Icy\Steam\ISteamService
	 */
	private $steam;
	/**
	 * @var IAuthenticationService
	 */
	private $auth;

	public function __construct(IBanService $banService, IFavouriteService $favouriteService, ISteamService $steam, IAuthenticationService $auth)
	{
		// user must be logged in to follow
		$this->beforeFilter('auth');

		$this->banService = $banService;
		$this->favouriteService = $favouriteService;
		$this->steam = $steam;

		$this->auth = $auth;
	}

	public function favourite($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);
		if ($steamId === false)
			return App::abort(404);

		$userId = $this->auth->userId();

		$steamIdRecord = $this->banService->fetchAndUpdate($steamId);

		// FIXME: We need to make sure the user has activated their account/email before they can follow anyone

		$this->favouriteService->favourite($userId, $steamIdRecord->id);

		FlashHelper::append('alerts.success', 'You are now following ' . $steamIdRecord->steamid);

//		return Redirect::action('steamid.display', ['id' => $steamIdRecord->steamid]);
		return Redirect::back();
	}

	public function unfavourite($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);
		if ($steamId === false)
			return App::abort(404);

		$userId = $this->auth->userId();

		$steamIdRecord = $this->banService->fetchAndUpdate($steamId);

		$this->favouriteService->unfavourite($userId, $steamIdRecord->id);

		FlashHelper::append('alerts.success', 'You have unfollowed ' . $steamIdRecord->steamid);

//		return Redirect::action('steamid.display', ['id' => $steamIdRecord->steamid]);
		return Redirect::back();
	}

} 