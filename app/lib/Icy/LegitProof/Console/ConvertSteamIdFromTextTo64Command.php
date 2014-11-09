<?php namespace Icy\LegitProof\Console;
use Icy\LegitProof\LegitProofCrawl;
use Icy\Steam\ISteamService;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/3/2014
 * Time: 3:48 PM
 */
class ConvertSteamIdFromTextTo64Command extends \BaseCommand {

	protected $name = 'esea:convert';

	protected $description = 'Convert steamids in database from text to 64 id.';

	private $steam;
	private $eseaBan;

	public function __construct(ISteamService $steam)
	{
		parent::__construct();

		$this->steam = $steam;
	}

	public function fire()
	{
		$this->line('Converting esea ban steamids...', 'black-yellow');

		$recordsArray = [];

		LegitProofCrawl::chunk(1000, function ($records) use (&$recordsArray)
		{
			foreach ($records as $record)
			{
				if ($this->steam->isTextId($record->steamid))
				{
					$original = $record->steamid;
					$converted = $this->steam->convertTextTo64($original);

					$record->steamid = $converted;

					$recordsArray[] = [

					];
				}
			}

		});

		$this->line('Finished.', 'black-green');
	}

	private function createArray($steamId)
	{

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

} 