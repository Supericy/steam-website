<?php namespace Icy\Common;
use Illuminate\Cache\CacheManager;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 11/7/2014
 * Time: 12:46 AM
 */

abstract class CachedRepository extends AbstractRepository {

	/**
	 * @var Repository
	 */
	private $cache;

	public function __construct(CacheManager $cache)
	{
		$this->cache = $cache;
	}

	protected function cache()
	{
		return $this->cache;
	}

} 