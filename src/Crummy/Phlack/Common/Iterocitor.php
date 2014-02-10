<?php

namespace Crummy\Phlack\Common;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Common\Responder\ResponderInterface;
use Crummy\Phlack\Message\MessageInterface;
use Crummy\Phlack\WebHook\Reply\EmptyReply;
use Crummy\Phlack\WebHook\Reply\Reply;

class Iterocitor implements ResponderInterface
{
    private $client;

    /**
     * @param array $options
     */
    public function __construct($options = [ ])
    {
        if ($options instanceof PhlackClient) {
            $this->client = $options;
        } else {
            $this->client = new PhlackClient($options);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function say($text)
    {
        return new Reply( ['text' => $text ]);
    }

    /**
     * {@inheritDoc}
     */
    public function emote($text)
    {
        return $this->say(sprintf('/me %s', $text));
    }

    /**
     * {@inheritDoc}
     */
    public function tell($user, $text)
    {
        return $this->say(sprintf('/msg %s %s', $user, $text));
    }

    /**
     * {@inheritDoc}
     */
    public function send(MessageInterface $message)
    {
        $command = $this->client->getCommand('Send', $message->jsonSerialize());

        $this->client->execute($command);

        return new EmptyReply();
    }
}
