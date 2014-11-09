<?php namespace Icy\Steam\Console;

use Icy\IBanService;
use Icy\Steam\ISteamService;
use Icy\Steam\SteamId;

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
	private $banService;
//	private $log;

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct(ISteamService $steam, IBanService $banService)
	{
		parent::__construct();

		$this->steam = $steam;
//		$this->steamId = $steamId;
		$this->banService = $banService;
//		$this->log = true;
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

		\DB::table('steamids')
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
//		dd('disabled (so that i don\'t have to disable cron job');

		$this->info('Running vac:update command...');
		\Log::info('Running vac:update command...');
//		$this->logInfo('Running vac:update command...');

		$chunk = 100;

		\DB::disableQueryLog();

		SteamId::chunk($chunk, function ($records)
		{
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

						$this->line(sprintf('{id:%d, steamid:%d, vac_status:%d, times_checked:%d}', $record->id, $record->steamid, $newVacStatus->isBanned(), $record->times_checked));

						$this->banService->checkForVacBans($record, $newVacStatus);
					}
				}

				$this->incrementTimesChecked($records);
			}

		});
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
