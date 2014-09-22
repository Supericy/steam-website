<?php namespace Icy\OAuth;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/22/2014
 * Time: 3:06 AM
 */


interface IOAuthAccountRepository {

	public function create(array $values);

	public function getByProviderAndAccountId($provider, $accountId);

}