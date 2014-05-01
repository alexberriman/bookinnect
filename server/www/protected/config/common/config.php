<?php

/**
 * Common config file.
 *
 * @author Alex Berriman <alex@ajberri.com>
 */
 
return [
    'components' => [
        'db' => [
			'emulatePrepare'  =>  true,
			'charset'  =>  'utf8',
            'tablePrefix' => '',
		],
    ],
];