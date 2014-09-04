<?php namespace Icy\BanListener;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 6:58 PM
 */

interface IBanListenerRepository {

	public function firstOrCreate(array $values);

}