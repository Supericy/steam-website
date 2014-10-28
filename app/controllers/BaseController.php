<?php
use Illuminate\Auth\Guard;
use Illuminate\Routing\Controller;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/27/2014
 * Time: 5:00 PM
 */

class BaseController extends Controller {

	/**
	 * @var Guard
	 */
	protected $auth;

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

} 