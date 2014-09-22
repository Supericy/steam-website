<?php namespace Icy\OAuth;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/22/2014
 * Time: 3:02 AM
 */

class OAuthAccountRepository implements IOAuthAccountRepository {

	private $model;
	private $oauthProvider;

	public function __construct(OAuthAccount $model, IOAuthProviderRepository $oauthProvider)
	{
		$this->model = $model;
		$this->oauthProvider = $oauthProvider;
	}

	public function create(array $values)
	{
		return $this->model->create($values);
	}

	public function getByProviderAndAccountId($provider, $accountId)
	{
		$oauthProviderRecord = $this->oauthProvider->getByName($provider);

		if (!$oauthProviderRecord)
			return false;

		$providerId = $oauthProviderRecord->id;

		return $this->model->where('account_id', $accountId)
			->where('provider_id', $providerId)->first();
	}

}