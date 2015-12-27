<?php

/** @var \Guzzle\Service\Client $api */
$api = require __DIR__.'/api_client.php';

echo 'Fetching Files List...'.PHP_EOL;

$result = $api->listFiles();

if (!$result['ok']) {
    die('FAIL! Error was: '.$result['error'].PHP_EOL);
}

$paging = $result['paging'];
while ($paging['pages'] >= $paging['page']) {
    printf(PHP_EOL.'Page %d of %d (%d total files):'.PHP_EOL,
        $paging['page'],
        $paging['pages'],
        $paging['total']
    );

    foreach ($result['files'] as $file) {
        echo "\t".$file['title'].PHP_EOL;
    }

    $nextPage = ++$paging['page'];
    $result = $api->listFiles(['page' => $nextPage]);
    $paging = $result['paging'];
}
