<?php namespace Icy\Common;
use Illuminate\Log\Writer;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 11/4/2014
 * Time: 7:12 AM
 */

trait LoggableTrait {

//	protected $levels = array(
//		'debug',
//		'info',
//		'notice',
//		'warning',
//		'error',
//		'critical',
//		'alert',
//		'emergency',
//	);

	/** @var Writer $__log  */
	private $__log = null;

	public function setLog(Writer $log)
	{
		$this->__log = $log;
	}

	public function getLog()
	{
		return $this->__log;
	}

//	public function debug($message, array $context = array())
//	{
//		if ($this->__log !== null)
//			$this->__log->debug($message, $context);
//	}
//	public function info($message, array $context = array())
//{
//	if ($this->__log !== null)
//		$this->__log->info($message, $context);
//}
//	public function notice($message, array $context = array())
//	{
//		if ($this->__log !== null)
//			$this->__log->notice($message, $context);
//	}
//	public function warning($message, array $context = array())
//	{
//		if ($this->__log !== null)
//			$this->__log->warning($message, $context);
//	}
//	public function error($message, array $context = array())
//	{
//		if ($this->__log !== null)
//			$this->__log->error($message, $context);
//	}
//	public function critical($message, array $context = array())
//	{
//		if ($this->__log !== null)
//			$this->__log->critical($message, $context);
//	}
//	public function alert($message, array $context = array())
//	{
//		if ($this->__log !== null)
//			$this->__log->alert($message, $context);
//	}
//	public function emergency($message, array $context = array())
//	{
//		if ($this->__log !== null)
//			$this->__log->emergency($message, $context);
//	}

} 