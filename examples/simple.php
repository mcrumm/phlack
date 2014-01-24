<?php

$client  = require __DIR__ . '/client.php';
$phlack  = new \Crummy\Phlack\Phlack($client);
$message = new \Crummy\Phlack\Message\Message('Hello, from phlack!');

echo 'Message Payload:' . PHP_EOL . $message . PHP_EOL;
echo 'Result:' . PHP_EOL;
var_dump($phlack->send($message));