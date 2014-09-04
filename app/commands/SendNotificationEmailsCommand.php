<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendNotificationEmailsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'vac:notify';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send the notification emails for users that have been VAC banned';

	private $log;

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		$this->log = true;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
//		DB::disableQueryLog();

		Icy\Steam\SteamId::where('changed', '=', 1)->with('banListeners')->chunk(100, function ($steamIdRecords) {

			foreach ($steamIdRecords as $steamIdRecord)
			{
				$this->logInfo($steamIdRecord);
				$this->info($steamIdRecord->steamid . ' has changed');

				$banListenerRecords = $steamIdRecord->banListeners;

				foreach ($banListenerRecords as $banListenerRecord)
				{
					$user = $banListenerRecord->user;

					if ($user)
					{
						$this->logInfo('Sending notification to ' . $user->username . ' regarding ' . $steamIdRecord->steamid);
						$this->info('Sending notification to ' . $user->username . ' regarding ' . $steamIdRecord->steamid);

						$data = [
							'steamId' => $steamIdRecord->steamid
						];

						Mail::send('emails.ban-notification', $data, function($message) use ($user)
						{
							$message
								->to($user->email, $user->username)
								->subject('A user you\'re tracking has been VAC banned');
						});
					}
				}

				$steamIdRecord->changed = false;
				$steamIdRecord->save();
			}

		});
	}

	public function logInfo($string)
	{
		if ($this->log)
		{
			Log::info($string);
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
