<?php namespace Tests;

use Laracasts\TestDummy\Factory;
use Mockery;
use DB;

class TestCase extends \Illuminate\Foundation\Testing\TestCase {

	use \Innovative\Core\Testing\TestHelperTrait;

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		$app = require __DIR__.'/../bootstrap/start.php';

		// Setup sqlite file
		$sqlite = __DIR__.'/tests.sqlite';
		if ( ! file_exists($sqlite) )
		{
			touch($sqlite);
		}

		$this->factory = new Factory(__DIR__.'/factories');

		return $app;
	}

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		parent::setUp();

		// create an artisan object for calling migrations
		$artisan = $this->app->make('artisan');

		// call migrations specific to our tests, e.g. to seed the db
		$artisan->call('migrate');

		$artisan->call('migrate', array(
			'--package'  => 'innovative/core',
		));

		DB::beginTransaction();
	}

	/**
	 * Rollback transactions after each test.
	 */
	public function tearDown()
	{
		Mockery::close();
		DB::rollback();
	}

}
