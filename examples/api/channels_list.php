<?php

$api = require __DIR__.'/api_client.php';
$sequencer = new \Crummy\Phlack\Common\Formatter\Sequencer();

echo 'Fetching Channels List...'.PHP_EOL;

$result = $api->ListChannels();

if (!$result['ok']) {
    die('FAIL! Error was: '.$result['error'].PHP_EOL);
}

foreach ($result['channels'] as $channel) {
    $channelName = $sequencer->sequence('#'.$channel['id'], $channel['name']);
    printf('%s: %s'.PHP_EOL, $channelName, $channel['purpose']['value']);
}
