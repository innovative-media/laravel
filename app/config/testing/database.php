<?php

return array(

	'default' => 'sqlite',

	'connections' => array(

		'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => base_path().'/tests/tests.sqlite',
			'prefix'   => '',
		),

	),

);
