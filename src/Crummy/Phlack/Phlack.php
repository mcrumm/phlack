<?php

namespace Crummy\Phlack;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Bridge\Guzzle\Response\MessageResponse;
use Crummy\Phlack\Message\MessageInterface;
use Guzzle\Common\Collection;

class Phlack extends Collection
{
    /**
     * @param PhlackClient $client
     */
    public function __construct(PhlackClient $client)
    {
        parent::__construct([
            'client'   => $client,
            'builders' => [],
            'commands' => [
                'send' => 'Send'
            ],
        ]);
    }

    /**
     * @param array $config
     * @return Phlack
     */
    static public function factory(array $config = [ ])
    {
        return new self(PhlackClient::factory($config));
    }

    /**
     * {@inhertiDoc}
     */
    public static function fromConfig(array $config = array(), array $defaults = array(), array $required = array())
    {
        return new self($config['client']);
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
