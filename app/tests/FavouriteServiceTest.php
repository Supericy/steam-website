<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/26/2014
 * Time: 12:24 AM
 */
use Icy\IFavouriteService;

/**
 * Class FavouriteServiceTest
 * @group FavouriteService
 */
class FavouriteServiceTest extends TestCase {

	public function test_favourite()
	{

	}

	public function test_unfavourite()
	{

	}

	public function test_getAllFavourites()
	{
		/** @var IFavouriteService $favouriteService */
		$favouriteService = $this->app->make('Icy\Favourite\IFavouriteService');

		$favourites = $favouriteService->getAllFavourites(8);

		dd($favourites);

//		dd([
//			$favourites[0]->steamid,
//			$favourites[0]->email
//		]);

//		$expected = [
//
//		];

//		$this->assertEquals($expected, $favourites);
	}

	public function test_isFavourited()
	{

	}

	public function test_enableNotification()
	{

	}

	public function test_disableNotification()
	{

	}

}
 