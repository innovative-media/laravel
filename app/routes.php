<?php

/*
|--------------------------------------------------------------------------
| Load Application Routes from {app}/Http/Routes
|--------------------------------------------------------------------------
*/

if ( $files = File::allFiles(app_path().'/Http/Routes') )
{
	foreach ( $files as $file )
	{
		require $file;
	}
}
