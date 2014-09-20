<?php namespace Icy\BanDetection;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 4:36 PM
 */

interface IBanDetectionRepository {

	public function firstOrCreate(array $values);

	public function create(array $values);

}