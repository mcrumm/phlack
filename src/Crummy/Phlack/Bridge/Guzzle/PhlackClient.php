<?php

namespace Crummy\Phlack\Bridge\Guzzle;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

class PhlackClient extends Client
{
    public static function factory($config = array())
    {
        $default  = [
            'base_url'        => PhlackPlugin::BASE_URL,
            'request.options' => [
                'exceptions'  => false,
            ],
        ];
        $required = [ 'username', 'token' ];

        $config = Collection::fromConfig($config, $default, $required);
        $client = new self($config['base_url'], $config);

        $client->addSubscriber(new PhlackPlugin($config['username'], $config['token']));
        $client->setDescription(ServiceDescription::factory(__DIR__.'/Resources/slack.json'));

        return $client;
    }
}
