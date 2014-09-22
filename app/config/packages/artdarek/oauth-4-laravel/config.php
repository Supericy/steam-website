<?php 

return array( 
	
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
	'consumers' => array(

		/*
		 * Google
		 */
		'Google' => array(
			'client_id' => '273077973467-h8etbp571pmgjas7vqkslueo6sfseqo3.apps.googleusercontent.com',
			'client_secret' => 'nCgAkX6JbS5JwIxeRD_GbleE',
			'scope' => array('userinfo_email', 'userinfo_profile'),
		)

	)

);