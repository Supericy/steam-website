<?php namespace Icy\Steam\Web\States;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/14/2014
 * Time: 4:42 AM
 */

class CommunityVisibilityState extends AbstractState {

	/*
	 * This represents whether the profile is visible or not, and if it is visible, why you are allowed to see it.
	 * Note that because this WebAPI does not use authentication, there are only two possible values returned:
	 * 		1 - the profile is not visible to you (Private, Friends Only, etc),
	 * 		3 - the profile is "Public", and the data is visible.
	 */
	protected $states = [
		1 => 'Not Visible',
		3 => 'Visible'
	];

} 