<?php

namespace Crummy\Phlack;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Builder\AttachmentBuilder;
use Crummy\Phlack\Builder\MessageBuilder;
use Crummy\Phlack\Message\MessageInterface;
use Guzzle\Http\Exception\BadResponseException;

class Phlack
{
    const MESSAGE_COMMAND = 'Message';

    private $client;
    private $messageBuilder;
    private $attachmentBuilder;

    /**
     * @param PhlackClient $client
     */
    public function __construct(PhlackClient $client)
    {
        $this->client = $client;
        $this->messageBuilder    = new MessageBuilder();
        $this->attachmentBuilder = new AttachmentBuilder();
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

    /**
     * @return MessageBuilder
     */
    public function getMessageBuilder()
    {
        return $this->messageBuilder;
    }

    /**
     * @return AttachmentBuilder
     */
    public function getAttachmentBuilder()
    {
        return $this->attachmentBuilder;
    }

    /**
     * @param array $config
     * @return Phlack
     */
    public function create($config = [ ])
    {
        return new self(PhlackClient::factory($config));
    }
}
