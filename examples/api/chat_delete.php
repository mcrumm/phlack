<?php

$api = require __DIR__.'/api_client.php';

if ($argc < 3 || (isset($argv[1]) && '--help' === $argv[1])) {
    die('Usage: '.$argv[0].' <channel> <timestamp>'.PHP_EOL);
}

printf('Deleting Message %s@%s'.PHP_EOL, $argv[1], $argv[2]);

$result = $api->DeleteMessage([
    'channel' => $argv[1],
    'ts'      => $argv[2],
]);

if (!$result['ok']) {
    die('FAIL! Error was: '.$result['error'].PHP_EOL);
}

print_r($result);
