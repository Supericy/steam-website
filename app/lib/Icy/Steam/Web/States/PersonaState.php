<?php namespace Icy\Steam\Web\States;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/14/2014
 * Time: 4:36 AM
 */

class PersonaState extends AbstractState {

	/*
	 * 0 - Offline, 1 - Online, 2 - Busy, 3 - Away, 4 - Snooze, 5 - looking to trade, 6 - looking to play.
	 *
	 * If the player's profile is private, this will always be "0",
	 * except is the user has set his status to looking to trade or looking to play,
	 * because a bug makes those status appear even if the profile is private.
	 */
	protected $states = [
		0 => 'Offline',
		1 => 'Online',
		2 => 'Busy',
		3 => 'Away',
		4 => 'Snooze',
		5 => 'Looking to Trade',
		6 => 'Looking to Play'
	];

} 