<?php namespace Icy\LegitProof\Console;
use Icy\LegitProof\ILegitProofService;
use Icy\LegitProof\LegitProofLeagueExperience;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 11/4/2014
 * Time: 8:23 AM
 */

class LegitProofCrawlerCommand extends \BaseCommand {
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'legitproof:crawl';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Crawl legit-proof for data';
	/**
	 * @var ILegitProofService
	 */
	private $legitproof;


	public function __construct(ILegitProofService $legitproof)
	{
		parent::__construct();
		$this->legitproof = $legitproof;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->setLog(App::make('log'));

		\DB::disableQueryLog();

		$this->line('Running legitproof:crawl command...');

		// TODO fetch from db so that we don't add duplicate data
		$id = (int)$this->argument('start');
		$endid = (int)$this->argument('end');

		$this->line('Running legitproof:crawl command... ' . $id . ' => ' . $endid);

		while ($id <= $endid)
		{
			try
			{
				$experienceObjects = $this->legitproof->getLeagueExperienceByUserId($id);

				if ($experienceObjects === false)
				{
					$this->line('Experience returned false for id: ' . $id . ', weird.', 'red');

					$id++;
					continue;
				}

//				502194
//				602120
//				703311

				if (empty($experienceObjects))
				{
					$this->line(sprintf('No experience found for: %8d %8d', $id, $endid), 'red');
					$id++;
					continue;
				}

				$this->line(sprintf('Data for user: %8d %8d', $id, $endid), 'black-yellow');
				foreach ($experienceObjects as $exp)
				{
					$this->line(sprintf('new:%s, %s, %s', $exp->getPlayer(), $exp->getTeam(), $exp->getLeague()), 'green');
				}

				DB::table('legitproof_crawl')->insert($this->createRecordArrays($id, $experienceObjects));
			}
			catch(Exception $e)
			{
				$this->line($e->getMessage(), 'black-red');
				$this->getLog()->warning($e->getMessage(), ['exception-trace' => $e->getTrace()]);
			}

			$id++;
		}
	}

	private function createRecordArrays($lpUserId, array $experienceObjects)
	{
		$exps = [];

		foreach ($experienceObjects as $exp)
		{
			$exps[] = $this->createRecordArray($lpUserId, $exp);
		}

		return $exps;
	}

	private function createRecordArray($lpUserId, LegitProofLeagueExperience $exp)
	{
		return [
			'lp_user_id' => $lpUserId,
			'guid' => $exp->getGuid(),
			'player' => $exp->getPlayer(),
			'team' => $exp->getTeam(),
			'league' => $exp->getLeague(),
			'division' => $exp->getDivision(),
			'join' => $exp->getJoinTimestamp(),
			'leave' => $exp->getLeaveTimestamp()
		];
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['start', InputArgument::REQUIRED, 'Id to start at.'],
			['end', InputArgument::REQUIRED, 'ID to end at (inclusive)']
		];
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
