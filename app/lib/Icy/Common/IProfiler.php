<?php namespace Icy\Common;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/26/2014
 * Time: 10:28 PM
 */

interface IProfiler {

	public function startMeasure($name, $label = null);

	public function stopMeasure($name);

} 