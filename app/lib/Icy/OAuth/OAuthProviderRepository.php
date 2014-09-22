<?php 
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/22/2014
 * Time: 3:15 AM
 */
namespace Icy\OAuth;


class OAuthProviderRepository implements IOAuthProviderRepository {

	private $model;

	public function __construct(OAuthProvider $model)
	{
		$this->model = $model;
	}

	public function getByName($name)
	{
		// this is a table of constants, so let's cache this value for a -long- time.
		return $this->model->where('name', $name)->remember(3600)->first();
	}

} 