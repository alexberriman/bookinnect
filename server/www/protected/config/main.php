<?php

/**
 * Main configuration file
 * Merges a subset of configuration files in to the one.
 *
 * @author Alex Berriman <alex@ajberri.com>
 */
 
return CMap::mergeArray(
    require(dirname(__FILE__) . '/main/config.php'),
    require(dirname(__FILE__) . '/common/config.php'),
    require(dirname(__FILE__) . '/main/main-local.php'),
    require(dirname(__FILE__) . '/common/common-local.php')
);