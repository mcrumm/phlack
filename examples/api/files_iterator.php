<?php

/** @var \Guzzle\Service\Client $api */
$api = require __DIR__.'/api_client.php';

echo 'Fetching All Files...'.PHP_EOL;

$iterator = $api->getIterator('ListFiles');

$i = 0;
foreach ($iterator as $file) {
    $i++;
    echo $file['title'].PHP_EOL;
}

echo PHP_EOL.'Retrieved '.$i.' files.'.PHP_EOL;
