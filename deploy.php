<?php

/*
|--------------------------------------------------------------------------
| Application deployment scripting
|--------------------------------------------------------------------------
|
| You may configure automated deployment to stages with the scripting below
| The defaults required to deploy a standard laravel project to a prepared
| stage are provided.  Make sure to replace SEVER_NAME, SEVER_NAME, USER,
| and REPO_PATH before getting started.
|
| Note that your deployment stage will require certain dependencies and
| permissions in order to operate.
|
*/

require 'recipe/common.php';

server('SEVER_NAME', 'IP_ADDRESS')
	->path('/server/USER/www')
	->user('USER')
	->pubKey('/share/.ssh/deploy_rsa.pub', '/share/.ssh/deploy_rsa');

stage('production', ['SEVER_NAME'], ['branch'=>'master'], true);

set('repository',    'REPO_PATH');
set('shared_dirs',   ['app/storage','uploads']);
set('shared_files',  ['.env.php']);
set('writable_dirs', ['app/storage','uploads']);

task('database:migrate', function()
{
	run("php current/artisan migrate --package=innovative/core --force");
	run("php current/artisan migrate --force");
});

task('laravel:create_storage_dirs', function()
{
	run("mkdir -p shared/app/storage/sessions");
	run("mkdir -p shared/app/storage/views");
	run("mkdir -p shared/app/storage/meta");
	run("mkdir -p shared/app/storage/logs");
	run("mkdir -p shared/app/storage/cache");
});

task('deploy', [
	'deploy:start',
	'deploy:prepare',
	'deploy:update_code',
	'deploy:shared',
	'deploy:writable_dirs',
	'laravel:create_storage_dirs',
	'deploy:vendors',
	'deploy:symlink',
	'database:migrate',
	'cleanup',
	'deploy:end',
])
->desc('Deploy to production');
