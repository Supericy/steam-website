<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/20/2014
 * Time: 6:19 PM
 */ 

class OAuthLoginController extends Controller {

	public function loginWithGoogle()
	{
		$google = OAuth::consumer('Google');

		if (Input::has('code'))
		{
			// redirected back from google
			// store code, get user email

		}
		else
		{
			return Redirect::to($google->getAuthorizationUri());
		}
	}
	
}