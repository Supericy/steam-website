<?php
use Icy\Authentication\IAuthenticationService;
use Icy\Favourite\IFavouriteRepository;
use Icy\ILeagueExperienceService;
use Icy\Steam\ISteamIdRepository;
use Icy\Steam\ISteamService;

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
	private $steamIdRepository;
	private $favouriteRepository;
	private $experienceService;
	/**
	 * @var IAuthenticationService
	 */
	private $auth;

	public function __construct(
		ISteamIdRepository $steamIdRepository,
		IFavouriteRepository $favouriteRepository,
		ILeagueExperienceService $experienceService,
		ISteamService $steam,
		IAuthenticationService $auth)
	{
		$this->steam = $steam;
		$this->steamIdRepository = $steamIdRepository;
		$this->favouriteRepository = $favouriteRepository;
		$this->experienceService = $experienceService;
		$this->auth = $auth;
	}

	public function search()
	{
		$potentialId = Input::get('steamid');

		if ($potentialId === null || empty($potentialId))
		{
			// no steamId given, so prompt the user for one
			return View::make('steamid.prompt');
		}

		$steamId = $this->steam->resolveId($potentialId);

		if ($steamId === false)
		{
			return Redirect::back()
				->withErrors(['steamid' => 'Nothing found.']);
		}

		return Redirect::action('steamid.display', ['id' => $steamId]);
	}

	public function display($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);
		if ($steamId === false)
			return App::abort(404);

		$steamIdRecord = $this->steamIdRepository->getBySteamId($steamId);
		Debugbar::info($steamIdRecord);

		$isFollowing = false;
		if ($this->auth->check())
			$isFollowing = $this->favouriteRepository->isFavourited($this->auth->userId(), $steamIdRecord->id);

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

//		Debugbar::info($data);

		return View::make('steamid.display')->with($data);
	}

} 