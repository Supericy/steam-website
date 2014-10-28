<?php namespace Icy\Esea\Console;

use Icy\Esea\IEseaBanRepository;

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
	 * Create a new command instance.
	 *
	 */
	public function __construct(\Illuminate\Foundation\Application $app, \Illuminate\Log\Writer $log, IEseaBanRepository $ban, \Icy\Steam\ISteamService $steam)
	{
		parent::__construct();

		$this->app = $app;
		$this->log = $log;
		$this->ban = $ban;
		$this->steam = $steam;

		$this->enableLog = true;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function fire()
	{
		$this->line('Updating ESEA bans...', 'black-yellow');

//		DB::disableQueryLog();

//		dd($this->ban->getLatestTimestamp());

		$downloadUri = $this->app->config['esea']['download_uri'];
//		$downloadPath = $this->app->config['esea']['download_path'];

//		$contents = $this->download($downloadUri);

//		if ($contents === false)
//			dd('Download returned false');

		$latestTimestamp = $this->ban->getLatestTimestamp();

		$added = 0;


		$this->csvReadExecute($downloadUri, function ($csv, $isFirst) use ($latestTimestamp, &$added)
		{

			// first line is meta data, so skip it
			if (!$isFirst)
			{
				$steamId = $csv[0];
				$alias = $csv[1];
				$lastname = $csv[2];
				$firstname = $csv[3];
				$timestamp = $this->dateToTimestamp($csv[4]);

//				dd($timestamp);

				if ($timestamp > $latestTimestamp)
				{
//					$this->info('Adding ' . $steamId . ':' . $alias . ':' . $timestamp);

					// new value, add to db
					$record = $this->ban->create([
						'steamid' => $this->steam->convertTextTo64($steamId),
						'alias' => $alias,
						'lastname' => $lastname,
						'firstname' => $firstname,
						'timestamp' => $timestamp,
					]);

					$this->info(sprintf('%4d: added. %16s %16s %16s', $record->id, $steamId, $alias, $timestamp), 'green');

					$added++;
				} else
				{
//					$this->line("Skipping " . $steamId . ':' . $alias . ':' . $timestamp, 'green');


					// tell our csv reader that we're finished with the file, no need to keep reading
					$this->csvFinished(true);
				}
			}

		});

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