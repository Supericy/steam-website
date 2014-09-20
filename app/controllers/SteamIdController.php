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
	private $user;
	private $banListener;
	private $banManager;

//	public function __construct(Icy\Steam\ISteamService $steam, Icy\Steam\ISteamIdRepository $steamId, Icy\User\IUserRepository $user, Icy\BanListener\IBanListenerRepository $banListener)
	public function __construct(Icy\IBanManager $banManager, Icy\Steam\ISteamService $steam, Icy\User\IUserRepository $user)
	{
//		dd($steam);
		$this->steam = $steam;
//		$this->steamId = $steamId;
		$this->user = $user;
//		$this->banListener = $banListener;
		$this->banManager = $banManager;
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

	// TODO move auth functionality to API controller
	private function authGetUser()
	{
		$userRecord = false;

		if (Auth::check())
		{
			$userRecord = Auth::user();
		}
		else if (Input::has('auth_token'))
		{
			$userAuthToken = Input::get('auth_token');
			$userRecord = $this->user->getByAuthToken($userAuthToken);
		}

		return $userRecord;
	}

	public function createBanListener($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);

		if ($steamId === false)
			return App::abort(404);

		$userId = false;

		// TODO export this functionality to API controller
		$userRecord = $this->authGetUser();

		if ($userRecord)
		{
			$userId = $userRecord->id;
		}

		if ($userId === false)
		{
			// not authorized
			return App::abort(401);
		}

		$steamIdRecord = $this->banManager->updateVacStatus($steamId);

		$banListenerRecord = $this->banManager->createBanListener($userId, $steamIdRecord->id);

		FlashHelper::append('alerts.success', 'You are now following ' . $steamIdRecord->steamid);

		return Redirect::action('steamid.display', ['id' => $steamIdRecord->steamid]);
	}

	public function removeBanListener($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);
		if ($steamId === false)
			return App::abort(404);
	}

	public function display($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);

		if ($steamId === false)
			return App::abort(404);

		$steamIdRecord = $this->banManager->updateVacStatus($steamId);

		$isFollowing = false;

		Debugbar::info($steamIdRecord);

		if ($userRecord = $this->authGetUser())
			$isFollowing = $this->banManager->isUserFollowing($userRecord->id, $steamIdRecord->id);

		$data = [
			'steamId' => $steamIdRecord->steamid,
			'vacBanned' => $steamIdRecord->vac_banned,
			'isFollowing' => $isFollowing,
			'timesChecked' => $steamIdRecord->times_checked,
		];

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

    public function displaySteamIdPrompt()
    {
		return View::make('steamid.prompt');
    }

	public function createSteamId()
	{
		$rules = [
			'steamid' => 'required'
		];

		$validator = Validator::make(Input::get(), $rules);

		if ($validator->fails())
		{
			if (Request::ajax())
				return Response::json($validator->messages());
			else
				return Redirect::back()->withErrors($validator);
		}

		$steamId = $this->steam->resolveId(Input::get('steamid'));

		if ($steamId === false)
		{
			$err = 'Enter a valid steam ID.';

			if (Request::ajax())
			{
				return Response::json($err, 400);
			}
			else
			{
				return Redirect::back()->withErrors(['steamid' => [$err]]);
			}
		}

		$steamIdRecord = $this->banManager->updateVacStatus($steamId);

		$url = URL::action('steamid.display', ['id' => $steamIdRecord->steamid]);
		FlashHelper::append('alerts.success', 'This profile is now being tracked.');

		if (Request::ajax())
			return Response::json(['success' => true, 'steamId' => $steamId, 'profile-url' => $url]);
		else
			return Redirect::to($url);
	}

} 