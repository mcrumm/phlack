<?php

$client = require __DIR__.'/client.php';
$phlack = new \Crummy\Phlack\Phlack($client);
$message = $phlack->getMessageBuilder()
                        ->setText('This message was sent at: '.date('Y-m-d H:i:s'))
                        ->setChannel('#general')
                        ->setUsername('message-builder')
                        ->setIconEmoji('clock330')
                        ->create();

echo 'Message Payload:'.PHP_EOL.$message.PHP_EOL;
echo 'Result:'.PHP_EOL;
var_dump($phlack->send($message));
