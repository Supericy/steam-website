<?php 
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/22/2014
 * Time: 3:14 AM
 */
namespace Icy\OAuth;


interface IOAuthProviderRepository {

	public function getByName($name);

} 