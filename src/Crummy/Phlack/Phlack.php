<?php

namespace Crummy\Phlack;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Bridge\Guzzle\Response\MessageResponse;
use Crummy\Phlack\Common\Exception\UnexpectedTypeException;
use Guzzle\Common\Collection;
use JsonSerializable;

class Phlack extends Collection
{
    /**
     * Phlack Constructor.
     *
     * @param mixed $client
     *
     * @throws UnexpectedTypeException
     */
    public function __construct($client)
    {
        if (is_string($client) || is_array($client)) {
            $client = new PhlackClient($client);
        } elseif (!$client instanceof PhlackClient) {
            throw new UnexpectedTypeException($client, ['string', 'array', 'Crummy\Phlack\Bridge\Guzzle\PhlackClient']);
        }

        parent::__construct([
            'client'   => $client,
            'builders' => [],
            'commands' => [
                'send' => 'Send',
            ],
        ]);
    }

    /**
     * Phlack Factory.
     *
     * @param array|string $config
     *
     * @return Phlack
     */
    public static function factory($config = [])
    {
        return new self(new PhlackClient($config));
    }

    /**
     * @return Phlack
     */
    public static function fromConfig(array $config = [], array $defaults = [], array $required = [])
    {
        return new self(new PhlackClient($config));
    }

    /**
     * @param string|array|JsonSerializable $message
     *
     * @throws UnexpectedTypeException
     *
     * @return MessageResponse
     */
    public function send($message)
    {
        return $this['client']->getCommand($this['commands']['send'], $this->toParameters($message))->execute();
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

    /**
     * @param mixed $message
     *
     * @throws UnexpectedTypeException
     *
     * @return array
     */
    private function toParameters($message)
    {
        if (is_string($message)) {
            return $this->getMessageBuilder()->setText($message)->create()->jsonSerialize();
        } elseif (is_array($message)) {
            return $message;
        } elseif ($message instanceof JsonSerializable) {
            return $message->jsonSerialize();
        }

        throw new UnexpectedTypeException($message, ['string', 'array', 'JsonSerializable']);
    }
}
