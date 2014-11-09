<?php namespace Icy\Esea\Console;

use Icy\Esea\EseaBanStatus;
use Icy\Esea\IEseaBanRepository;
use Icy\IBanService;
use Icy\Steam\ISteamService;
use Illuminate\Foundation\Application;
use Illuminate\Log\Writer;

class DownloadBanListCommand extends \BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'esea:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Download new bans from esea and store in database.';

	private $app;
	private $log;
	private $ban;
	private $steam;

	private $enableLog;
	/**
	 * @var IBanService
	 */
	private $banService;

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct(
		Application $app,
		Writer $log,
		IEseaBanRepository $ban,
		ISteamService $steam,
		IBanService $banService)
	{
		parent::__construct();

		$this->app = $app;
		$this->log = $log;
		$this->ban = $ban;
		$this->steam = $steam;

		$this->enableLog = true;
		$this->banService = $banService;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function fire()
	{
		$this->line('Running esea:update command...', 'black-yellow');
		\Log::info('Running esea:update command...');

		\DB::disableQueryLog();

		$downloadUri = $this->app->config['esea']['download_uri'];

		$added = 0;

		$recordsToAdd = [];

		$records = \DB::select('select steamid, timestamp from esea_bans ');

		$inserted = [];

		foreach ($records as $r)
			$inserted[$r->steamid . "_" . $r->timestamp] = true;

		$this->csvReadExecute($downloadUri, function ($csv, $isFirst) use (&$inserted, &$recordsToAdd, &$added)
		{

			// first line is meta data, so skip it
			if (!$isFirst)
			{
				$steamIdText = trim($csv[0]);
				$alias = $csv[1];
				$lastname = $csv[2];
				$firstname = $csv[3];
				$timestamp = $this->dateToTimestamp($csv[4]);

				$steamId = $this->steam->convertTextTo64($steamIdText);

//				$steamIdRecord = $this->banService->fetchAndUpdate($steamId);

				try
				{
					if (!isset($inserted[$steamId . "_" . $timestamp]))
					{
						$recordsToAdd[] = [
							'steamid' => $steamId,
							'alias' => $alias,
							'lastname' => $lastname,
							'firstname' => $firstname,
							'timestamp' => $timestamp,
						];

						$recordAdded = true;
					}
					else
					{
						$recordAdded = false;
					}

					// new value, add to db
//					$eseaRecord = $this->ban->create();

//					$this->banService->checkForEseaBans($steamIdRecord, new EseaBanStatus(true, $alias, $timestamp));

					$this->info(sprintf('%16s %16s %16s %16s', $recordAdded ? 'added' : 'skip', $steamIdText, $alias, $timestamp), $recordAdded ? 'yellow' : 'green');

					if (count($recordsToAdd) >= 50)
					{
						$added += count($recordsToAdd);
						foreach ($recordsToAdd as $r)
							$inserted[$r['steamid'] . "_" . $r['timestamp']] = true;

						\DB::table('esea_bans')->insert($recordsToAdd);
						$recordsToAdd = [];
					}
				}
				catch (\Exception $e)
				{
					$this->line($e->getMessage(), 'black-red');
					// $this->csvFinished(true);
				}
			}

		});

		if (count($recordsToAdd) > 0)
		{
			$added += count($recordsToAdd);
			foreach ($recordsToAdd as $r)
				$inserted[$r['steamid'] . "_" . $r['timestamp']] = true;

			\DB::table('esea_bans')->insert($recordsToAdd);
			$recordsToAdd = [];
		}

		$this->line(sprintf('Update finished. %d record(s) added.', $added), 'black-green');
	}

	public function dateToTimestamp($date)
	{
		$parsed = \date_parse_from_format("D, d M Y H:i:s T", $date);

		$timestamp = mktime(
			$parsed['hour'],
			$parsed['minute'],
			$parsed['second'],
			$parsed['month'],
			$parsed['day'],
			$parsed['year']
		);

		return $timestamp;
	}

	public function csvFinished($bool)
	{
		$this->csvFinished = $bool;
	}

	public function csvReadExecute($endpoint, Callable $callback)
	{
		$context = stream_context_create([
			'http' => [
				'header' => "Cookie: viewed_welcome_page=1"
			]
		]);

		$handle = fopen($endpoint, "r", false, $context);

		$this->csvFinished(false);

		$first = true;

		while (!$this->csvFinished && ($csv = fgetcsv($handle, 256)) !== false)
		{
			$callback($csv, $first);
			$first = false;
		}

		fclose($handle);
	}

	public function download($endpoint)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->app->config['esea']['cookie_file']);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->app->config['esea']['cookie_file']);

		if (($erno = curl_error($ch)) > 0)
		{
			$reason = sprintf('An error (erno:%d) occured while trying to curl: %s', $erno, $endpoint);

			throw new Exception($reason);
		}
		if (curl_error($ch) === CURLE_OPERATION_TIMEOUTED)
		{
			throw new Exception('Steam API timed out.');
		}

		return curl_exec($ch);
	}

	public function logInfo($string)
	{
		if ($this->enableLog)
		{
			$this->log->info($string);
		}
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