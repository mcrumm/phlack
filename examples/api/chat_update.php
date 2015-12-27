<?php

$api = require __DIR__.'/api_client.php';

if ($argc < 4 || (isset($argv[1]) && '--help' === $argv[1])) {
    die('Usage: '.$argv[0].' <channel> <timestamp> <text> [as_user]'.PHP_EOL);
}

printf('Updating Message %s@%s'.PHP_EOL, $argv[1], $argv[2]);

$args = [
    'channel' => $argv[1],
    'ts'      => $argv[2],
    'text'    => $argv[3],
];

$result = $api->UpdateMessage($args);

if (!$result['ok']) {
    die('FAIL! Error was: '.$result['error'].PHP_EOL);
}

print_r($result);
