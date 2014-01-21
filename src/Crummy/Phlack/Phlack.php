<?php

namespace Crummy\Phlack;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Message\MessageInterface;

class Phlack
{
    const MESSAGE_COMMAND = 'Message';

    private $client;

    /**
     * @param PhlackClient $client
     */
    public function __construct(PhlackClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param MessageInterface $message
     * @return array|\Guzzle\Http\Message\Response
     */
    public function send(MessageInterface $message)
    {
        $command = $this->client->getCommand(self::MESSAGE_COMMAND, $message->jsonSerialize());
        return $this->client->execute($command);
    }

    /**
     * @return PhlackClient
     */
    public function getClient()
    {
        return $this->client;
    }
}
