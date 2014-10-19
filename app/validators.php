<?php

Validator::extend('steamid', function ($attribute, $value, $parameters)
{

	// valid variations of a steamid
	$patterns = [
		// text-form id
		'/(STEAM_)?[0-1]:[0-1]:\d{1,12}/i',

		// 64-bit id
		'/\d{17}/',
	];

	$matches = true;

	while ($matches && ($pattern = array_pop($patterns)) !== null)
	{
		$matches = preg_match($pattern, $value);
	}

	return $matches;
}, 'Must be a valid Steam ID.');