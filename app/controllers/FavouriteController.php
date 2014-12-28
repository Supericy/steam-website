<?php
use Icy\Authentication\IAuthenticationService;
use Icy\Ban\IBanNotificationRepository;
use Icy\Favourite\IFavouriteRepository;
use Icy\Favourite\IFavouriteService;
use Icy\Steam\ISteamIdRepository;
use Icy\Steam\ISteamService;
use Icy\User\IUserRepository;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/15/2014
 * Time: 9:49 PM
 */
class FavouriteController extends Controller {

	/**
	 * @var IFavouriteRepository
	 */
	private $favouriteRepository;
	/**
	 * @var ISteamService
	 */
	private $steam;
	/**
	 * @var IAuthenticationService
	 */
	private $auth;
	/**
	 * @var ISteamIdRepository
	 */
	private $steamIdRepository;
	/**
	 * @var IBanNotificationRepository
	 */
	private $banNotificationRepository;
	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(
		ISteamIdRepository $steamIdRepository,
		IFavouriteRepository $favouriteRepository,
		ISteamService $steam,
		IAuthenticationService $auth,
		IBanNotificationRepository $banNotificationRepository,
		IUserRepository $userRepository)
	{
		// user must be logged in to follow
		$this->beforeFilter('auth');

		$this->steamIdRepository = $steamIdRepository;
		$this->favouriteRepository = $favouriteRepository;
		$this->steam = $steam;
		$this->auth = $auth;
		$this->banNotificationRepository = $banNotificationRepository;
		$this->userRepository = $userRepository;
	}

	public function enableNotification($potentialId, $banName)
	{
		$steamIdRecord = $this->steam->resolveId($potentialId);
		if ($steamIdRecord === false)
			return App::abort(404);

		$steamIdRecord = $this->steamIdRepository->getBySteamId($steamIdRecord);

		$favourite = $this->favouriteRepository->getByUserIdAndSteamIdId($this->auth->userId(), $steamIdRecord->id);

		if (!$favourite)
		{
			return App::abort(404);
		}

		$this->banNotificationRepository->enableNotification($favourite->id, $banName);

		FlashHelper::append('alerts.success', 'Ban Notification for ' . strtoupper($banName) . ' has been enabled.');

		return Redirection::back();
	}

	public function disableNotification($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);
		if ($steamId === false)
			return App::abort(404);
	}

	public function favourite($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);
		if ($steamId === false)
			return App::abort(404);

		$user = $this->auth->currentUser();

		$steamIdRecord = $this->steamIdRepository->getBySteamId($steamId);

		$user->addFavourite($steamIdRecord);

		$this->userRepository->save($user);

//		$userId = $this->auth->userId();

//

		// FIXME: We need to make sure the user has activated their account/email before they can follow anyone

//		$this->favouriteRepository->favourite($userId, $steamIdRecord->id);

		FlashHelper::append('alerts.success', 'You are now following ' . $steamIdRecord->steamid);

//		return Redirect::action('steamid.display', ['id' => $steamIdRecord->steamid]);
		return Redirect::back();
	}

	public function unfavourite($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);
		if ($steamId === false)
			return App::abort(404);

		$user = $this->auth->currentUser();

		$steamIdRecord = $this->steamIdRepository->getBySteamId($steamId);

		$user->addFavourite($steamIdRecord);
		$this->userRepository->save($user);

//		$userId = $this->auth->userId();
//		$steamIdRecord = $this->steamIdRepository->getBySteamId($steamId);
//		$this->favouriteRepository->unfavourite($userId, $steamIdRecord->id);

		FlashHelper::append('alerts.success', 'You have unfollowed ' . $steamIdRecord->steamid);

//		return Redirect::action('steamid.display', ['id' => $steamIdRecord->steamid]);
		return Redirect::back();
	}

} 