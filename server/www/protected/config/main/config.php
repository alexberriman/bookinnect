<?php

/**
 * Local configuration file.
 *
 * @author Alex Berriman <alex@ajberri.com>
 */

return [
	'basePath' => dirname(__FILE__) . '/../..',
	'name' => 'Bookinnect',

	// preloading 'log' component
	'preload' => ['log'],

	// autoloading model and component classes
	'import' => [
		'application.models.*',
		'application.components.*',
	],
    
	// application components
	'components' => [
		'user' => [
			// enable cookie-based authentication
			'allowAutoLogin' => true,
		],

		'urlManager' => [
			'urlFormat' => 'path',
			'rules' => [
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			],
		],
        
		'errorHandler' => [
			// use 'site/error' action to display errors
			'errorAction' => 'site/error',
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

	'params' => [
		// this is used in contact page
		'adminEmail' => 'webmaster@example.com',
	],
];