<?php namespace Icy\Steam\Web\States;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/14/2014
 * Time: 4:44 AM
 */

class ProfileState extends AbstractState {

	/*
	 * If set, indicates the user has a community profile configured (will be set to '1')
	 */
	protected $states = [
		0 => 'Community Profile Not Configured',
		1 => 'Community Profile Configred'
	];

} 