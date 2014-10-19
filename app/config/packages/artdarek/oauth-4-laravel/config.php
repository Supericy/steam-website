<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		/*
		 * Google
		 */
		'Google' => [
			'client_id' => '273077973467-h8etbp571pmgjas7vqkslueo6sfseqo3.apps.googleusercontent.com',
			'client_secret' => 'nCgAkX6JbS5JwIxeRD_GbleE',
			'scope' => ['userinfo_email', 'userinfo_profile'],
		]

	]

];