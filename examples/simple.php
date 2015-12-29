<?php

$client = require __DIR__.'/client.php';
$phlack = new \Crummy\Phlack\Phlack($client);

$response = $phlack->send('Hello, from Phlack!');

echo 'Response:'.PHP_EOL;
var_dump($response);
