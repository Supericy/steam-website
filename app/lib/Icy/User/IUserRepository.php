<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 6:48 PM
 */

interface IUserRepository {

	public function getByEmail($email);

	public function getByAuthToken($token);

	public function create(array $values);

}