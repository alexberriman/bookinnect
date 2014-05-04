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
    
    // aliases
    'aliases' => [
        'bootstrap' => realpath(__DIR__) . '/../../extensions/bootstrap',
    ],

	// autoloading model and component classes
	'import' => [
		'application.models.*',
		'application.components.*',
        'ext.giix-components.*',
        'bootstrap.helpers.*',
	],
    
	// application components
	'components' => [
        'bootstrap' => [
            'class' => 'bootstrap.components.TbApi',   
        ],
        
		'user' => [
			// enable cookie-based authentication
			'allowAutoLogin' => true,
		],

		'urlManager' => [
			'urlFormat' => 'path',
            'showScriptName' => false,
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