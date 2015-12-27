<?php

date_default_timezone_set('America/Los_Angeles');

require __DIR__.'/../../vendor/autoload.php';

if (!file_exists(__DIR__.'/../config.json')) {
    throw new \RuntimeException('Please create examples/config.json before running the examples.');
}

/*
 * Using the ServiceBuilder is not necessary,
 * it just simplifies loading configurations for the examples.
 * @var \Guzzle\Service\Builder\ServiceBuilder
 */
return \Guzzle\Service\Builder\ServiceBuilder::factory(__DIR__.'/../config.json')->get('phlack_api');
