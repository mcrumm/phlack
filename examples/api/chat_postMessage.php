<?php

$api = require __DIR__.'/api_client.php';

if (isset($argv[1]) && '--help' === $argv[1]) {
    die('Usage: '.$argv[0].' [text] [channel] [as_user]'.PHP_EOL);
}

$args = [
    'text'    => isset($argv[1]) ? $argv[1] : 'Hello, from Phlack!',
    'channel' => isset($argv[2]) ? $argv[2] : '#general',
];

if (isset($argv[3])) {
    $args['as_user'] = $argv[3];
}

echo 'Posting Test Message...'.PHP_EOL;

$result = $api->PostMessage($args);

if (!$result['ok']) {
    die('FAIL! Error was: '.$result['error'].PHP_EOL);
}

print_r($result);
