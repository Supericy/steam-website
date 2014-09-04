<?php namespace Icy\Steam;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/28/14
 * Time: 11:16 AM
 */

interface ISteamService {

	public function isVacBanned($steamId);

	public function resolveId($potentialId);

	public function convertTextTo64($textId);

	public function communityUrl($steamId);

}