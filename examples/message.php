<?php

date_default_timezone_set('America/Los_Angeles');

require __DIR__.'/../vendor/autoload.php';

if (!file_exists(__DIR__.'/config.json')) {
    throw new \RuntimeException('Please create config.json before running the examples.');
}

/**
 * Using the ServiceBuilder is not necessary,
 * it just simplifies loading configurations for the examples.
 * @var \Guzzle\Service\Builder\ServiceBuilder
 */
$serviceBuilder = \Guzzle\Service\Builder\ServiceBuilder::factory(__DIR__.'/config.json');

$phlack  = new \Crummy\Phlack\Phlack($serviceBuilder->get('phlack'));
$message = $phlack->getMessageBuilder()
                        ->setText('This message was sent at: ' . date('Y-m-d H:i:s'))
                        ->setIconEmoji('clock3')
                        ->create();

echo 'Message Payload:' . PHP_EOL . $message . PHP_EOL;
echo 'Result:' . PHP_EOL;
var_dump($phlack->send($message));