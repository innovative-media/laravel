<?php

/*
|---------------------------------------------------------------------------------
| Application Routes
|---------------------------------------------------------------------------------
|
| You can define all of your routes in this file, or use the loader below
| to load routes from a group of files located in the app/Http/Routes directory.
|
*/

if ( $files = File::allFiles(app_path().'/Http/Routes') )
{
	foreach ( $files as $file )
	{
		require $file;
	}
}
