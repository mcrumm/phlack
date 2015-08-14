<?php

namespace Crummy\Phlack;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Bridge\Guzzle\Response\MessageResponse;
use Crummy\Phlack\Common\Exception\UnexpectedTypeException;
use Crummy\Phlack\Message\MessageInterface;
use Guzzle\Common\Collection;

class Phlack extends Collection
{
    /**
     * Phlack Constructor.
     *
     * @param mixed $client
     * @throws UnexpectedTypeException
     */
    public function __construct($client)
    {
        if (is_string($client) || is_array($client)) {
            $client = new PhlackClient($client);
        } elseif (! $client instanceof PhlackClient) {
            throw new UnexpectedTypeException($client, ['string', 'array', 'Crummy\Phlack\Bridge\Guzzle\PhlackClient']);
        }

        parent::__construct([
            'client'   => $client,
            'builders' => [],
            'commands' => [
                'send' => 'Send'
            ],
        ]);
    }

    /**
     * Phlack Factory.
     *
     * @param array|string $config
     * @return Phlack
     */
    static public function factory($config = [ ])
    {
        return new self(new PhlackClient($config));
    }

    /**
     * @return Phlack
     */
    public static function fromConfig(array $config = array(), array $defaults = array(), array $required = array())
    {
        return new self(new PhlackClient($config));
    }

    /**
     * @param MessageInterface $message
     * @return MessageResponse
     */
    public function send(MessageInterface $message)
    {
        $command = $this['client']->getCommand($this['commands']['send'], $message->jsonSerialize());
        return $this['client']->execute($command);
    }

    /**
     * @return Bridge\Guzzle\PhlackClient
     */
    public function getClient()
    {
        return $this['client'];
    }

    /**
     * @return Builder\MessageBuilder
     */
    public function getMessageBuilder()
    {
        if (!isset($this['builders']['message'])) {
            $this->setPath('builders/message', new Builder\MessageBuilder());
        }

        return $this['builders']['message'];
    }

    /**
     * @return Builder\AttachmentBuilder
     */
    public function getAttachmentBuilder()
    {
        if (!isset($this['builders']['attachment'])) {
            $this->setPath('builders/attachment', new Builder\AttachmentBuilder());
        }

        return $this['builders']['attachment'];
    }
}
