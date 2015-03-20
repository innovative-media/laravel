<?php namespace App\Console\Commands;

class Setup {

	public static function postCreateProject($event)
	{
		$io = $event->getIO();

		$command = new static;
		$command->fire($io);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire($io)
	{
		$io->write("********************************************************");
		$io->write("* Innovative Core Setup                                *");
		$io->write("*                                                      *");
		$io->write("* Please answer the following questions to start       *");
		$io->write("* building with core.  Note: this is going to          *");
		$io->write("* take up to 15 minutes to install. Go get a coffee :) *");
		$io->write("********************************************************");

		$projectName   = $io->ask('Project name:');
		$projectDomain = $io->ask('Live domain name:');
		$databaseName  = $io->ask('Database Name:');
		$databaseUser  = $io->ask('Database User:');
		$databasePass  = $io->ask('Database Password:');

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
		$this->replaceInFile('PROJECT_NAME', $name, getcwd().'/composer.json');
	}

	/**
	 * Set project domain
	 *
	 * @param  string $domain
	 * @return void
	 */
	protected function projectDomain($domain)
	{
		$this->replaceInFile('PROJECT_DOMAIN', $domain, getcwd().'/app/config/app.php');
	}

	/**
	 * Set database connection
	 *
	 * @param  string $domain
	 * @return void
	 */
	protected function projectDatabase($database, $username, $password)
	{
		$this->replaceInFile('DATABASE_NAME', $database, getcwd().'/app/config/local/database.php');
		$this->replaceInFile('DATABASE_USER', $username, getcwd().'/app/config/local/database.php');
		$this->replaceInFile('SET_DATABASE_PASSWORD', $password, getcwd().'/.env.local.php', getcwd().'/.env.template');
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

		if ( file_exists($source) )
		{
			$contents = file_get_contents($source);

			$contents = str_replace($search, $replacement, $contents);

			file_put_contents($destination, $contents);
		}
	}

}
