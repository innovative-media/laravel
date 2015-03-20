<?php namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SetupCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup your project for immediate use.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info("********************************************************");
		$this->info("* Innovative Core Setup                                *");
		$this->info("*                                                      *");
		$this->info("* Please answer the following questions to start       *");
		$this->info("* building with core.  Note: this is going to          *");
		$this->info("* take up to 15 minutes to install. Go get a coffee :) *");
		$this->info("********************************************************");

		$projectName   = $this->ask('Project name:');
		$projectDomain = $this->ask('Live domain name:');
		$databaseName  = $this->ask('Database Name:');
		$databaseUser  = $this->ask('Database User:');
		$databasePass  = $this->ask('Database Password:');

		$this->projectName($projectName);
		$this->projectDomain($projectDomain);
		$this->projectDatabase($databaseName, $databaseUser, $databasePass);
	}

	/**
	 * Set project name
	 *
	 * @param  string $name
	 * @return void
	 */
	protected function projectName($name)
	{
		$this->replaceInFile('PROJECT_NAME', $name, base_path().'/composer.json');
	}

	/**
	 * Set project domain
	 *
	 * @param  string $domain
	 * @return void
	 */
	protected function projectDomain($domain)
	{
		$this->replaceInFile('PROJECT_DOMAIN', $domain, base_path().'/app/config/app.php');
	}

	/**
	 * Set database connection
	 *
	 * @param  string $domain
	 * @return void
	 */
	protected function projectDatabase($database, $username, $password)
	{
		$this->replaceInFile('DATABASE_NAME', $database, base_path().'/app/config/local/database.php');
		$this->replaceInFile('DATABASE_USER', $username, base_path().'/app/config/local/database.php');
		$this->replaceInFile('SET_DATABASE_PASSWORD', $password, base_path().'/.env.local.php', base_path().'/.env.template');
	}

	/**
	 * Run string replacement on given file
	 *
	 * @param  string $search
	 * @param  string $replacement
	 * @param  string $destination
	 * @return void
	 */
	protected function replaceInFile($search, $replacement, $destination, $source = null)
	{
		$source = $source ?: $destination;

		if ( File::exists($source) )
		{
			$contents = File::get($source);

			$contents = str_replace($search, $replacement, $contents);

			File::put($destination, $contents);
		}
	}


}
