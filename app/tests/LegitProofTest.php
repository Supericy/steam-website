<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 5:19 PM
 */

/**
 * Class LegitProofTest
 * @group LegitProof
 */
class LegitProofTest extends TestCase {

	public function test_getLeagueExperience()
	{
		/** @var Icy\LegitProof\ILegitProof $legitproof */
		$legitproof = $this->app->make('Icy\LegitProof\ILegitProof');

		$this->assertInstanceOf('Icy\LegitProof\ILegitProof', $legitproof, 'App is not returning an instance of Icy\LegitProof\ILegitProof');

		/*
		 * NOTES FOR THESE TESTS:
		 * 		These results are based off my own steamid, if these tests fail:
		 * 			MAKE SURE TO GO TO LEGIT-PROOF AND MAKE SURE THE DATA IS THE SAME, THE TEST MAY BE OUTDATED
		 *
		 * 		Legit-Proofs DOM may change at any time, causing these tests to fail. If they do fail:
		 * 			FIRST THING TO DO IS CHECK LEGIT-PROOF DOM FOR CHANGES
		 */

		$lpLeagueExperience = $legitproof->getLeagueExperience('0:0:30908');

		$this->assertEquals(2, count($lpLeagueExperience));

		$exp0 = $lpLeagueExperience[0];
		$exp1 = $lpLeagueExperience[1];

		// legit-proof website may change, so if this test fails, first check to see if legit-proofs DOM has changed
		$this->assertEquals('0:0:30908', $exp0->getGuid());
		$this->assertEquals('Chad "soundwave" Kosie', $exp0->getPlayer());
		$this->assertEquals('Extinguishers Exterminating Ex cal-o f@gs', $exp0->getTeam());
		$this->assertEquals('XPL', $exp0->getLeague());
		$this->assertEquals('5v5 Registration', $exp0->getDivision());
		$this->assertEquals('2009-09-23', $exp0->getJoin());
		$this->assertEquals('2010-01-27', $exp0->getLeave());

		$this->assertEquals('0:0:30908', $exp1->getGuid());
		$this->assertEquals('Chad "Supericy" Kosie', $exp1->getPlayer());
		$this->assertEquals('Digital Excellence', $exp1->getTeam());
		$this->assertEquals('CEVO', $exp1->getLeague());
		$this->assertEquals('Open', $exp1->getDivision());
		$this->assertEquals(Icy\LegitProof\LegitProofLeagueExperience::UNKNOWN_DATE, $exp1->getJoin());
		$this->assertEquals(Icy\LegitProof\LegitProofLeagueExperience::UNKNOWN_DATE, $exp1->getLeave());
	}

}
 