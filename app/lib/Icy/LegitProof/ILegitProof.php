<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 4:51 PM
 */
namespace Icy\LegitProof;


/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 4:21 PM
 */
interface ILegitProof {

	/**
	 * @param string $steamIdText
	 * 		Must be a TEXT steamid, ('STEAM_' part is optional)
	 * @return LegitProofLeagueExperience[]
	 */
	public function getLeagueExperience($steamIdText);

}