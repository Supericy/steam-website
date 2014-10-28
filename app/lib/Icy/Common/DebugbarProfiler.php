<?php namespace Icy\Common;
use Barryvdh\Debugbar\LaravelDebugbar;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/26/2014
 * Time: 10:29 PM
 */

class DebugbarProfiler implements IProfiler {

	/**
	 * @var LaravelDebugbar
	 */
	private $debugbar;

	public function __construct(LaravelDebugbar $debugbar)
	{
		$this->debugbar = $debugbar;
	}

	public function startMeasure($name, $label = null)
	{
		$this->debugbar->startMeasure($name, $label);
	}

	public function stopMeasure($name)
	{
		$this->debugbar->stopMeasure($name);
	}

}