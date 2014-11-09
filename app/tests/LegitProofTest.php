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

	public function test_getLeagueExperienceByUserId()
	{
		/** @var Icy\LegitProof\ILegitProofService $legitproof */
		$legitproof = $this->app->make('Icy\LegitProof\ILegitProofService');

		$this->assertInstanceOf('Icy\LegitProof\ILegitProofService', $legitproof, 'App is not returning an instance of Icy\LegitProof\ILegitProofService');

		/*
		 * NOTES FOR THESE TESTS:
		 * 		These results are based off my own steamid, if these tests fail:
		 * 			MAKE SURE TO GO TO LEGIT-PROOF AND MAKE SURE THE DATA IS THE SAME, THE TEST MAY BE OUTDATED
		 *
		 * 		Legit-Proofs DOM may change at any time, causing these tests to fail. If they do fail:
		 * 			FIRST THING TO DO IS CHECK LEGIT-PROOF DOM FOR CHANGES
		 */

		$lpLeagueExperience = $legitproof->getLeagueExperienceByUserId(6178);

		$this->assertNotSame(false, $lpLeagueExperience);
		$this->assertEquals(6, count($lpLeagueExperience));

		$exp3 = $lpLeagueExperience[3];
		$exp1 = $lpLeagueExperience[0];

		// legit-proof website may change, so if this test fails, first check to see if legit-proofs DOM has changed
		$this->assertEquals('0:0:30908', $exp3->getGuid());
		$this->assertEquals('Chad "soundwave" Kosie', $exp3->getPlayer());
		$this->assertEquals('Extinguishers Exterminating Ex cal-o f@gs', $exp3->getTeam());
		$this->assertEquals('XPL', $exp3->getLeague());
		$this->assertEquals('5v5 Registration', $exp3->getDivision());
		$this->assertEquals('2009-09-23', $exp3->getJoin());
		$this->assertEquals('2010-01-27', $exp3->getLeave());
		$this->assertEquals(1253664000, $exp3->getJoinTimestamp());
		$this->assertEquals(1264550400, $exp3->getLeaveTimestamp());

		$this->assertEquals('M3owM1x', $exp1->getGuid());
		$this->assertEquals('Branden "meowmix" Glass', $exp1->getPlayer());
		$this->assertEquals('schooled', $exp1->getTeam());
		$this->assertEquals('CAL', $exp1->getLeague());
		$this->assertEquals('DOTA Open', $exp1->getDivision());
		$this->assertEquals('2006-02-28', $exp1->getJoin());
		$this->assertEquals('2006-04-25', $exp1->getLeave());
	}

	/**
	 * @group=LegitProofGetLeagueExperience
	 */
	public function test_getLeagueExperience()
	{
		/** @var Icy\LegitProof\ILegitProofService $legitproof */
		$legitproof = $this->app->make('Icy\LegitProof\ILegitProofService');

		$this->assertInstanceOf('Icy\LegitProof\ILegitProofService', $legitproof, 'App is not returning an instance of Icy\LegitProof\ILegitProofService');

		/*
		 * NOTES FOR THESE TESTS:
		 * 		These results are based off my own steamid, if these tests fail:
		 * 			MAKE SURE TO GO TO LEGIT-PROOF AND MAKE SURE THE DATA IS THE SAME, THE TEST MAY BE OUTDATED
		 *
		 * 		Legit-Proofs DOM may change at any time, causing these tests to fail. If they do fail:
		 * 			FIRST THING TO DO IS CHECK LEGIT-PROOF DOM FOR CHANGES
		 */

		$lpLeagueExperience = $legitproof->getLeagueExperience('0:0:30908');

		$this->assertNotSame(false, $lpLeagueExperience);
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
 