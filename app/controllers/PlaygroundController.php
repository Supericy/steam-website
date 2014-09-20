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
		Cache::put('test', 'hello world2', 60);

		return App::make('cache')->getDefaultDriver() . "::" . Cache::get('test');
	}

}