<?php
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
	private $banManager;
	/**
	 * @var \Icy\IFavouriteService
	 */
	private $favouriteManager;
	/**
	 * @var \Icy\Steam\ISteamService
	 */
	private $steam;

	public function __construct(IBanService $banManager, IFavouriteService $favouriteManager, ISteamService $steam)
	{
		$this->banManager = $banManager;
		$this->favouriteManager = $favouriteManager;
		$this->steam = $steam;

		// user must be logged in to follow
		$this->beforeFilter('auth');
	}

	public function favourite($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);

		if ($steamId === false)
			return App::abort(404);

		$userId = Auth::user()->id;

		$steamIdRecord = $this->banManager->fetchAndUpdate($steamId);

		// FIXME: We need to make sure the user has activated their account/email before they can follow anyone

		$this->favouriteManager->favourite($userId, $steamIdRecord->id);

		FlashHelper::append('alerts.success', 'You are now following ' . $steamIdRecord->steamid);

//		return Redirect::action('steamid.display', ['id' => $steamIdRecord->steamid]);
		return Redirect::back();
	}

	public function unfavourite($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);
		if ($steamId === false)
			return App::abort(404);

		$userId = Auth::user()->id;

		$steamIdRecord = $this->banManager->fetchAndUpdate($steamId);

		$this->favouriteManager->unfavourite($userId, $steamIdRecord->id);

		FlashHelper::append('alerts.success', 'You have unfollowed ' . $steamIdRecord->steamid);

//		return Redirect::action('steamid.display', ['id' => $steamIdRecord->steamid]);
		return Redirect::back();
	}

} 