<?php

$api = require __DIR__.'/api_client.php';
$sequencer = new \Crummy\Phlack\Common\Formatter\Sequencer();

echo 'Fetching Groups List...'.PHP_EOL;

$result = $api->ListGroups();

if (!$result['ok']) {
    die('FAIL! Error was: '.$result['error'].PHP_EOL);
}

foreach ($result['groups'] as $group) {
    $groupName = $sequencer->sequence('#'.$group['id'], $group['name']);
    printf('%s: %s'.PHP_EOL, $groupName, $group['purpose']['value']);
}
