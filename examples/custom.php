<?php

$client = require __DIR__.'/client.php';
$phlack = new \Crummy\Phlack\Phlack($client);

$response = $phlack->send([
    'channel'      => '#random',
    'icon_emoji'   => ':taco:',
    'username'     => 'Phlack',
    'unfurl_links' => true,
    'text'         => 'I :heart: the <http://api.slack.com|Slack API>!',
]);

echo 'Response:'.PHP_EOL;
var_dump($response);
