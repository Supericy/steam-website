<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/29/14
 * Time: 3:10 PM
 */

class PlaygroundController extends Controller {

	public function tests()
	{
//		$time = date_parse("1/2/20014");
//		$time = date_parse("Thu, 25 Sep 2014 04:37:42 +0000");

		$parsed = date_parse_from_format("D, d M Y H:i:s T", 'Thu, 25 Sep 2014 04:37:42 +0000');
//
		$timestamp = mktime(
			$parsed['hour'],
			$parsed['minute'],
			$parsed['second'],
			$parsed['month'],
			$parsed['day'],
			$parsed['year']
		);

		dd([$parsed, $timestamp]);
	}

}