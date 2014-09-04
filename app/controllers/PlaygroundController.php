<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/29/14
 * Time: 3:10 PM
 */

class PlaygroundController extends \BaseController {

	public function tests()
	{
//		Mail::send('emails.welcome', [], function($message)
//		{
//			$message->to('kosie150@gmail.com', 'John Smith')->subject('Welcome!');
//		});

		$this->apiKey = 'apikey';

		$params = [
			'steamid' => '0:0:30908'
		];

		return 'http://api.steampowered.com/ISteamUser/GetPlayerBans/v1/' . http_build_query(array_merge(['key' => $this->apiKey], $params));
	}

}