<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateVacBansCommand extends \BaseCommand {

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
		$this->log = true;
	}

	/**
	 * @param $records
	 */
	private function incrementTimesChecked($records)
	{
		$recordIds = [];

		foreach ($records as $record)
		{
			$recordIds[] = $record->id;
		}

		DB::table('steamids')
			->whereIn('id', $recordIds)
			->increment('times_checked');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		dd('disabled');

		$this->info('Running vac:update command...');
		$this->logInfo('Running vac:update command...');

		$chunk = 100;

		DB::disableQueryLog();

		/*
		 * disable incrementing the update counter on steamids because we
		 * will do bulk increments (1 sql qeury rather than 100s)
		 */
		$this->banManager->incrementOnUpdate(false);

		Icy\Steam\SteamId::chunk($chunk, function ($records) {

			$steamIds = [];

			foreach ($records as $record)
			{
				$steamIds[] = $record->steamid;
			}

			$bannedStatusList = $this->steam->getVacBanStatus($steamIds);

			if ($bannedStatusList !== false)
			{
				foreach ($records as $record)
				{
					if (array_key_exists($record->steamid, $bannedStatusList))
					{
						$newVacStatus = $bannedStatusList[$record->steamid];

						$this->info(sprintf('{id:%d, steamid:%d, vac_status:%d, times_checked:%d}', $record->id, $record->steamid, $newVacStatus->isBanned(), $record->times_checked));

						$this->banManager->fetchAndUpdate($record, $newVacStatus);
					}
				}

				$this->incrementTimesChecked($records);
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
