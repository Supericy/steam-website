<?php namespace Icy;
use Icy\Esea\EseaBanStatus;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 4:30 PM
 */

interface IBanService {

	public function checkForVacBans(Steam\SteamId $steamIdRecord, Steam\VacBanStatus $newVacStatus = null);

	public function checkForEseaBans(Steam\SteamId $steamIdRecord, EseaBanStatus $newEseaStatus = null);

}