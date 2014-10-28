<?php namespace Icy\Steam\Web\States;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/14/2014
 * Time: 4:03 AM
 */

abstract class AbstractState implements IState {

	protected $states = [];

	private $intValue;

	public function __construct($intValue)
	{
		$this->intValue = $intValue;
	}

	public function string()
	{
		return $this->states[$this->intValue];
	}

	public function integer()
	{
		return $this->intValue;
	}

	public static function fromInteger($int)
	{
		return new static($int, true);
	}

} 