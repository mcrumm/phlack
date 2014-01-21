<?php

namespace Crummy\Phlack\Bridge\Guzzle;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;

class PhlackClient extends Client
{
    public static function factory($config = array())
    {
        $default  = [ 'base_url' => PhlackPlugin::BASE_URL ];
        $required = [ 'username', 'token' ];

        $config = Collection::fromConfig($config, $default, $required);
        $client = new self($config['base_url'], $config);

        $client->addSubscriber(new PhlackPlugin($config['username'], $config['token']));

        return $client;
    }
}
