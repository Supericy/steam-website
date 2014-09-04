<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateVacBansCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'vac:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	private $steam;
	private $steamId;
	private $banManager;
	private $log;

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct(Icy\Steam\ISteamService $steam, Icy\IBanManager $banManager)
	{
		parent::__construct();

		$this->steam = $steam;
//		$this->steamId = $steamId;
		$this->banManager = $banManager;
		$this->log = false;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$count = Icy\Steam\SteamId::all()->count();
		$min = 0;
		$max = 100;
		$increment = 100;

		DB::disableQueryLog();

		$this->logInfo('Running vac:update command...');

		Icy\Steam\SteamId::chunk(100, function ($records) {

			$steamIds = [];

			foreach ($records as $record)
			{
				$steamIds[] = $record->steamid;
			}

			$bannedStatusList = $this->steam->isVacBanned($steamIds);

			if ($bannedStatusList !== false)
			{
				foreach ($records as $record)
				{
					if (array_key_exists($record->steamid, $bannedStatusList))
					{
						$newVacStatus = $bannedStatusList[$record->steamid];

						$this->info($record->id . ':' . $record->steamid . ':' . $newVacStatus, true);

						$this->banManager->updateVacStatus($record, $newVacStatus);
					}
				}
			}

		});

//		while ($min < $count)
//		{
//			$this->logInfo('Retrieving records [min=' . $min . ', max=' . $max . ']');
//			$records = Icy\Steam\SteamId::take($max)->skip($min)->get();
//
//			$steamIds = [];
//
//			foreach ($records as $record)
//			{
//				$steamIds[] = $record->steamid;
//			}
//
//			$bannedStatusList = $this->steam->isVacBanned($steamIds);
//
//			if ($bannedStatusList !== false)
//			{
//				foreach ($records as $record)
//				{
//					if (array_key_exists($record->steamid, $bannedStatusList))
//					{
//						$newVacStatus = $bannedStatusList[$record->steamid];
//
//						$this->info($record->id . ':' . $record->steamid . ':' . $newVacStatus, false);
//
//						if ($newVacStatus != $record->vac_banned)
//						{
//							$this->info(':new vac ban', false);
//
//							$record->vac_banned = $newVacStatus;
//							$record->changed = true;
//							$record->save();
//						}
//
//						echo "\n";
//					}
//				}
//			}
//
//			$min += $increment;
//			$max += $increment;
//		}
	}

	public function logInfo($string)
	{
		if ($this->log)
		{
			Log::info($string);
		}
	}

	public function info($string, $newline = true)
	{
		if ($newline)
			$this->output->writeln("<info>$string</info>");
		else
			$this->output->write("<info>$string</info>");
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
