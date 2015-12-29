<?php

$api = require __DIR__.'/api_client.php';
$sequencer = new \Crummy\Phlack\Common\Formatter\Sequencer();

echo 'Fetching IM List...'.PHP_EOL;

$result = $api->ListIM();

if (!$result['ok']) {
    die('FAIL! Error was: '.$result['error'].PHP_EOL);
}

foreach ($result['ims'] as $i => $im) {
    $userName = $sequencer->sequence('@'.$im['user']);
    printf('%s: %s'.PHP_EOL, $userName, $im['id']);
}
