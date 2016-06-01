<?php

namespace Crummy\Phlack\Common;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Common\Formatter\Sequencer;
use Crummy\Phlack\Common\Responder\ResponderInterface;
use Crummy\Phlack\Message\MessageInterface;
use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\Reply\EmptyReply;
use Crummy\Phlack\WebHook\Reply\Reply;

class Iterocitor implements ResponderInterface
{
    private $client;
    private $sequencer;

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->sequencer = new Sequencer();

        if ($options instanceof PhlackClient) {
            $this->client = $options;
        } else {
            $this->client = new PhlackClient($options);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function say($text)
    {
        return new Reply(['text' => $text]);
    }

    /**
     * "Emotes" a message into the channel.
     * {@inheritdoc}
     */
    public function emote($text)
    {
        return $this->important('channel', $text);
    }

    /**
     * Send a message to a user.
     *
     * @param string $user user_id
     *                     {@inheritdoc}
     */
    public function tell($user, $text)
    {
        return $this->say($this->sequencer->format('@'.$user).' '.$text);
    }

    /**
     * Respond with a reply to a user.
     *
     * @param CommandInterface|string user_id, or a CommandInterface containing user_id and user_name.
     * @param $text
     *
     * @return Reply
     */
    public function reply($user, $text)
    {
        if ($user instanceof CommandInterface) {
            $sequence = $this->sequencer->command($user);

            return $this->say($sequence['user'].' '.$text);
        }

        return $this->tell($user, $text);
    }

    /**
     * {@inheritdoc}
     */
    public function send(MessageInterface $message)
    {
        $command = $this->client->getCommand('Send', $message->jsonSerialize());

        $this->client->execute($command);

        return new EmptyReply();
    }

    /**
     * @param string $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function shout($text)
    {
        return $this->important('everyone', $text);
    }

    /**
     * @param string $where
     * @param string $text
     *
     * @return Reply
     */
    protected function important($where, $text)
    {
        return $this->say($this->sequencer->alert($where).' '.$text);
    }
}
