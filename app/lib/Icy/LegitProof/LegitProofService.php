<?php namespace Icy\LegitProof;
use Goutte\Client;
use Icy\Common\LoggableTrait;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 4:21 PM
 */

class LegitProofService implements ILegitProofService {

	use LoggableTrait;

	private $endpoints = [
		'search' => 'http://www.legit-proof.com/search/'
	];

	private $client;
	private $leagueExperienceRepository;

	public function __construct(Client $client, ILeagueExperienceRepository $leagueExperienceRepository)
	{
		$this->client = $client;
		$this->leagueExperienceRepository = $leagueExperienceRepository;
	}

	private function createEndpoint($endpointKey, $queryMethod, $steamIdText)
	{
		if (!in_array($queryMethod, ['guid', 'user_id']))
			dd($queryMethod . ' is not a valid queryMethod for createEndpoint in LegitProofService');

		if (!array_key_exists($endpointKey, $this->endpoints))
			dd($endpointKey . ' is not a valid endpoint for createEntpoint in LegitProofService');

		return $this->endpoints[$endpointKey] . '?' . http_build_query(['method' => $queryMethod, 'query' => $steamIdText]);
	}

	public function getLeagueExperienceByUserId($legitproofId)
	{
		/** @var \Symfony\Component\DomCrawler\Crawler $crawler */
		$crawler = $this->client->request('GET', $this->createEndpoint('search', 'user_id', $legitproofId));

		if (!$this->checkResponse())
			return false;

		return $this->getExperienceFromCrawler($crawler);;
	}

	public function getLeagueExperience($steamIdText)
	{
		/** @var \Symfony\Component\DomCrawler\Crawler $crawler */
		$crawler = $this->client->request('GET', $this->createEndpoint('search', 'guid', $steamIdText));

		if (!$this->checkResponse())
			return false;

		return $this->getExperienceFromCrawler($crawler);
	}

	private function checkResponse()
	{
		/** @var \Symfony\Component\BrowserKit\Response $response */
		$response = $this->client->getResponse();

		if ($response->getStatus() != 200)
		{
			$this->getLog()->info('LegitProof returned a non-200 response!', [$response->getStatus(), $response->getHeaders()]);
			return false;
		}

		return true;
	}

	/**
	 * @param $crawler
	 * @return mixed
	 */
	public function getExperienceFromCrawler($crawler)
	{
		$lpLeagueExperiences = [];

		$crawler->filter('#content > table.jqor > tbody > tr')->each(function ($node) use (&$lpLeagueExperiences)
		{
			/** @var \Symfony\Component\DomCrawler\Crawler $node */

			$rows = [];

			// get row text
			$node->filter('td')->each(function ($td) use (&$rows)
			{
				$rows[] = $td->text();
			});

			$exp = new LegitProofLeagueExperience();
			$exp->setGuid($rows[0]);
			$exp->setPlayer($rows[1]);
			$exp->setTeam($rows[2]);
			$exp->setLeague($rows[3]);
			$exp->setDivision($rows[4]);
			$exp->setJoin($rows[5]);
			$exp->setLeave($rows[6]);

			$lpLeagueExperiences[] = $exp;

		});

		return $lpLeagueExperiences;
	}

} 