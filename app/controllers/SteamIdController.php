<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/28/14
 * Time: 4:38 AM
 */

class SteamIdController extends \BaseController {

	const BULK_MAX_STEAMIDS = 100;

	private $steam;
	private $steamId;
	private $user;
	private $banListener;
	private $banManager;

//	public function __construct(Icy\Steam\ISteamService $steam, Icy\Steam\ISteamIdRepository $steamId, Icy\User\IUserRepository $user, Icy\BanListener\IBanListenerRepository $banListener)
	public function __construct(Icy\IBanManager $banManager, Icy\Steam\ISteamService $steam)
	{
//		dd($steam);
		$this->steam = $steam;
//		$this->steamId = $steamId;
//		$this->user = $user;
//		$this->banListener = $banListener;
		$this->banManager = $banManager;
	}

	public function createBanListener($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);

		if ($steamId === false)
			return App::abort(404);

		$userId = false;

		if (Auth::check())
		{
			$userId = Auth::user()->id;
		}
		else
		{
			if (Input::has('user_app_token'))
			{
				$userEntry = $this->user->getByAppToken(Input::get('user_app_token'));

				if ($userEntry)
				{
					$userId = $userEntry->id;
				}
			}
		}

		if ($userId === false)
		{
			// not authorized
			return App::abort(401);
		}

		$steamIdRecord = $this->banManager->updateVacStatus($steamId);

//		$steamIdEntry = $this->steamId->firstOrCreateAndUpdateVacStatus([
//			'steamid' => $steamId
//		]);

		$banListenerRecord = $this->banManager->createBanListener($userId, $steamIdRecord->id);

//		$banListenerEntry = $this->banListener->firstOrCreate([
//			'user_id' => $userId,
//			'steamid_id' => $steamIdEntry->id
//		]);

		FlashHelper::append('alerts.success', 'You are now tracking ' . $steamIdRecord->steamid);

		return Redirect::action('steamid.display', ['id' => $steamIdRecord->steamid]);
	}

	public function display($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);

		if ($steamId === false)
			return App::abort(404);

		$steamIdRecord = $this->banManager->updateVacStatus($steamId);
//		$entry = $this->steamId->firstOrCreateAndUpdateVacStatus([
//			'steamid' => $steamId
//		]);

		$data = [
			'steamId' => $steamIdRecord->steamid,
			'vacBanned' => $steamIdRecord->vac_banned
		];

		return View::make('steamid.display')->with($data);
	}

	public function createSteamIdBulk()
	{
		$potentialIds = Input::get('steamids');
		$potentialIds = explode(',', $potentialIds);
		$potentialIds = array_splice($potentialIds, 0, self::BULK_MAX_STEAMIDS);

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
//		$entry = $this->steamId->firstOrCreateAndUpdateVacStatus([
//			'steamid' => $steamId
//		]);

//		$url = $this->steam->communityUrl($entry->steamid);
		$url = URL::action('steamid.display', ['id' => $steamIdRecord->steamid]);
		FlashHelper::append('alerts.success', HTML::link($url, $steamIdRecord->steamid) . ' is now being tracked.');

		if (Request::ajax())
			return Response::json(['success' => true, 'steamId' => $steamId]);
		else
			return Redirect::back();
	}

} 