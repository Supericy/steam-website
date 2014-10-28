<?php namespace Icy\LegitProof;
use Goutte\Client;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 4:21 PM
 */

class LegitProofService implements ILegitProofService {

	private $endpoints = [
		'Search' => 'http://www.legit-proof.com/search/'
	];

	private $client;
	private $leagueExperienceRepository;

	public function __construct(Client $client, ILeagueExperienceRepository $leagueExperienceRepository)
	{
		$this->client = $client;
		$this->leagueExperienceRepository = $leagueExperienceRepository;
	}

	private function createSearchEndpoint($steamIdText)
	{
		return $this->endpoints['Search'] . '?' . http_build_query(['method' => 'guid', 'query' => $steamIdText]);
	}

	public function getLeagueExperience($steamIdText)
	{
		/** @var \Symfony\Component\DomCrawler\Crawler $crawler */
		$crawler = $this->client->request('GET', $this->createSearchEndpoint($steamIdText));

		/** @var \Symfony\Component\BrowserKit\Response $response */
		$response = $this->client->getResponse();

		if ($response->getStatus() !== 200)
		{
			return false;
		}

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