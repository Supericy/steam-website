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
	private $banService;
	private $favouriteService;
	private $experienceService;

	public function __construct(Icy\IBanService $banService, Icy\Favourite\IFavouriteService $favouriteService, Icy\ILeagueExperienceService $experienceService, Icy\Steam\ISteamService $steam)
	{
		$this->steam = $steam;
		$this->banService = $banService;
		$this->favouriteService = $favouriteService;
		$this->experienceService = $experienceService;
	}

	public function searchSteamId()
	{
		$potentialId = Input::get('steamid');

		if ($potentialId === null)
		{
			// no steamId given, so prompt the user for one
			return View::make('steamid.prompt');
		} else
		{
			$steamId = $this->steam->resolveId(Input::get('steamid'));

			return Redirect::action('steamid.display', ['id' => $steamId]);
		}
	}

	public function display($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);

		if ($steamId === false)
			return App::abort(404);

		$steamIdRecord = $this->banService->fetchAndUpdate($steamId);
//		Debugbar::info($steamIdRecord);

		$isFollowing = false;
		if (Auth::check())
			$isFollowing = $this->favouriteService->isFavourited(Auth::user()->id, $steamIdRecord->id);

		$leagueExperiences = $this->experienceService->getLeagueExperiences($steamId);

		$profile = $this->steam->getPlayerProfile($steamId);

		$data = [
			/** @var profile IPlayerProfile */
			'profile' => $profile,

			'steamId' => $steamIdRecord->steamid,
			'isFollowing' => $isFollowing,
			'timesChecked' => $steamIdRecord->times_checked,
			'hasBans' => $steamIdRecord->hasBans(),
			'bans' => $steamIdRecord->getAllBanStatuses(),
			'steamId64' => $steamIdRecord->steamid,
			'steamIdText' => $this->steam->convert64ToText($steamId, true),
			'hasLeagueExperiences' => count($leagueExperiences) > 0,
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