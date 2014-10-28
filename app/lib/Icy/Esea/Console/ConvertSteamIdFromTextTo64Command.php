<?php namespace Icy\Esea\Console;

use Icy\Esea\IEseaBanRepository;

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

	public function __construct(\Icy\Steam\ISteamService $steam, IEseaBanRepository $eseaBan)
	{
		parent::__construct();

		$this->steam = $steam;
		$this->eseaBan = $eseaBan;
	}

	public function fire()
	{
		$this->line('Converting esea ban steamids...', 'black-yellow');

		\Icy\Esea\EseaBan::chunk(100, function ($records)
		{

			foreach ($records as $record)
			{
				if ($this->steam->isTextId($record->steamid))
				{
					$original = $record->steamid;
					$converted = $this->steam->convertTextTo64($original);

					$this->line(sprintf('%4d: Converting %-14s => %s', $record->id, $original, $converted), 'green');

					$record->steamid = $converted;
					$record->save();
				}
			}

		});

		$this->line('Finished.', 'black-green');
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