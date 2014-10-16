<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/28/14
 * Time: 4:38 AM
 */

class SteamIdController extends Controller {

	// steam API's max steamids per request
	const BULK_MAX_STEAMIDS = 100;

	private $steam;
	private $steamId;
	private $banManager;
	private $followManager;
	private $experienceManager;

	public function __construct(Icy\IBanManager $banManager, Icy\IFollowManager $followManager, Icy\ILeagueExperienceManager $experienceManager, Icy\Steam\ISteamService $steam)
	{
		$this->steam = $steam;
		$this->banManager = $banManager;
		$this->followManager = $followManager;
		$this->experienceManager = $experienceManager;

		$this->filter('before', 'auth')
			->only(['follow', 'unfollow']);
	}

	public function searchSteamId()
	{
		$potentialId = Input::get('steamid');

		if ($potentialId === null)
		{
			// no steamId given, so prompt the user for one
			return View::make('steamid.prompt');
		}
		else
		{
			$steamId = $this->steam->resolveId(Input::get('steamid'));

			return Redirect::action('steamid.display', ['id' => $steamId]);
		}
	}

	// TODO export this functionality to API controller


	public function display($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);

		if ($steamId === false)
			return App::abort(404);

		$steamIdRecord = $this->banManager->fetchAndUpdate($steamId);
//		Debugbar::info($steamIdRecord);

		$isFollowing = false;
		if (Auth::check())
			$isFollowing = $this->followManager->isFollowing(Auth::user()->id, $steamIdRecord->id);

		$leagueExperiences = $this->experienceManager->getLeagueExperiences($steamId);

		$profile = $this->steam->getPlayerProfile($steamId);

		$data = [
			'steamId' => $steamIdRecord->steamid,
			'isFollowing' => $isFollowing,
			'timesChecked' => $steamIdRecord->times_checked,
			'hasBans' => $steamIdRecord->hasBans(),
			'bans' => $steamIdRecord->getAllBanStatuses(),
			'steamId64' => $steamIdRecord->steamid,
			'steamIdText' => $this->steam->convert64ToText($steamId, true),
			'leagueExperiences' => $leagueExperiences,
			'communityUrl' => $this->steam->getCommunityUrl($steamId),
		];

		Debugbar::info($data);

		return View::make('steamid.display')->with($data);
	}

	// TODO export this to API controller
	public function createSteamIdBulk()
	{
		$potentialIds = Input::get('steamids');
		$potentialIds = explode(',', $potentialIds);
//		$potentialIds = array_splice($potentialIds, 0, self::BULK_MAX_STEAMIDS);

		if (count($potentialIds) > self::BULK_MAX_STEAMIDS)
			App::abort(400, 'Max ' . self::BULK_MAX_STEAMIDS . ' steamids per request');

		$arrayOfValues = [];

		foreach ($potentialIds as $potentialId)
		{
			$arrayOfValues[] = [
				'steamid' => $this->steam->resolveId($potentialId)
			];
		}

		$this->steamId->createMany($arrayOfValues);

		return Response::json(['success' => true]);
	}

//    public function displaySteamIdPrompt()
//    {
//		return View::make('steamid.prompt');
//    }
//
//	public function createSteamId()
//	{
//		$rules = [
//			'steamid' => 'required'
//		];
//
//		$validator = Validator::make(Input::get(), $rules);
//
//		if ($validator->fails())
//		{
//			if (Request::ajax())
//				return Response::json($validator->messages());
//			else
//				return Redirect::back()->withErrors($validator);
//		}
//
//		$steamId = $this->steam->resolveId(Input::get('steamid'));
//
//		if ($steamId === false)
//		{
//			$err = 'Enter a valid steam ID.';
//
//			if (Request::ajax())
//			{
//				return Response::json($err, 400);
//			}
//			else
//			{
//				return Redirect::back()->withErrors(['steamid' => [$err]]);
//			}
//		}
//
//		$steamIdRecord = $this->banManager->fetchAndUpdate($steamId);
//
//		$url = URL::action('steamid.display', ['id' => $steamIdRecord->steamid]);
//		FlashHelper::append('alerts.success', 'This profile is now being tracked.');
//
//		if (Request::ajax())
//			return Response::json(['success' => true, 'steamId' => $steamId, 'profile-url' => $url]);
//		else
//			return Redirect::to($url);
//	}

} 