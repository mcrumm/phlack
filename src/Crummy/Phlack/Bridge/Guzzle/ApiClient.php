<?php

namespace Crummy\Phlack\Bridge\Guzzle;

use Guzzle\Common\Collection;
use Guzzle\Common\Event;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

class ApiClient extends Client
{
    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        $config = Collection::fromConfig($config, [], ['token']);
        parent::__construct('', $config);

        $description = ServiceDescription::factory(__DIR__.'/Resources/slack_api.json');
        $this->setDescription($description);

        $this->getEventDispatcher()->addListener('command.before_prepare', function (Event $event) use ($config) {
            $event['command']['token'] = $config['token'];
        });
    }

    /**
     * @param array $config
     *
     * @return ApiClient
     */
    public static function factory($config = [])
    {
        return new self($config);
    }
}
