<?php namespace Icy\Common;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/26/2014
 * Time: 10:21 PM
 */

trait MeasurableTrait {

	/** @var  IProfiler */
	private $__profiler = null;

	public function getProfiler()
	{
		return $this->__profiler;
	}

	public function setProfiler(IProfiler $profiler)
	{
		$this->__profiler = $profiler;
	}

	public function startMeasure($name, $label = null)
	{
		if ($this->__profiler !== null)
			$this->__profiler->startMeasure($name, $label);
	}

	public function stopMeasure($name)
	{
		if ($this->__profiler !== null)
			$this->__profiler->stopMeasure($name);
	}

} 