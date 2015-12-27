<?php

$api = require __DIR__.'/api_client.php';
$sequencer = new \Crummy\Phlack\Common\Formatter\Sequencer();

echo 'Fetching Users List...'.PHP_EOL;

$result = $api->ListUsers();

if (!$result['ok']) {
    die('FAIL! Error was: '.$result['error'].PHP_EOL);
}

foreach ($result['members'] as $user) {
    $userName = $sequencer->sequence('@'.$user['id'], $user['name']);
    printf('%s: %s'.PHP_EOL, $userName, $user['real_name']);
}
