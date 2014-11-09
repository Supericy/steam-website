<?php

use Illuminate\Console\Command;

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
