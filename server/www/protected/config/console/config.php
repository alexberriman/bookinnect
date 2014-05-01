<?php

/**
 * Main console configuration file.
 *
 * @author Alex Berriman <alex@ajberri.com>
 */

return [
	'basePath' => dirname(__FILE__).'/../..',
	'name' => 'Bookinnect Console Application',

	// preloading 'log' component
	'preload' => ['log'],

	// application components
	'components' => [
		'db' => [
			'connectionString'  =>  'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		],
		'log' => [
			'class' => 'CLogRouter',
			'routes' => [
				[
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				],
			],
		],
	],
];