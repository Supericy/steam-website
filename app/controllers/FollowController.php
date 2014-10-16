<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/15/2014
 * Time: 9:49 PM
 */

class FollowController extends Controller {

	/**
	 * @var \Icy\IBanManager
	 */
	private $banManager;
	/**
	 * @var \Icy\IFollowManager
	 */
	private $followManager;
	/**
	 * @var \Icy\Steam\ISteamService
	 */
	private $steam;

	public function __construct(Icy\IBanManager $banManager, Icy\IFollowManager $followManager, Icy\Steam\ISteamService $steam)
	{
		$this->banManager = $banManager;
		$this->followManager = $followManager;
		$this->steam = $steam;

		// user must be logged in to follow
		$this->filterBefore('auth');
	}

	public function follow($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);

		if ($steamId === false)
			return App::abort(404);

		$userId = Auth::user()->id;

		$steamIdRecord = $this->banManager->fetchAndUpdate($steamId);

		$this->followManager->follow($userId, $steamIdRecord->id);

		FlashHelper::append('alerts.success', 'You are now following ' . $steamIdRecord->steamid);

		return Redirect::action('steamid.display', ['id' => $steamIdRecord->steamid]);
	}

	public function unfollow($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);
		if ($steamId === false)
			return App::abort(404);

		$userId = Auth::user()->id;

		$steamIdRecord = $this->banManager->fetchAndUpdate($steamId);

		$this->followManager->unfollow($userId, $steamIdRecord->id);

		FlashHelper::append('alerts.success', 'You have unfollowed ' . $steamIdRecord->steamid);

		return Redirect::action('steamid.display', ['id' => $steamIdRecord->steamid]);
	}

} 