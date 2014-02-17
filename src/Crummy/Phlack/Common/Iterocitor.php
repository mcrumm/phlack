<?php

namespace Crummy\Phlack\Common;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Common\Formatter\SlackFormatter;
use Crummy\Phlack\Common\Responder\ResponderInterface;
use Crummy\Phlack\Message\MessageInterface;
use Crummy\Phlack\WebHook\CommandInterface;
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
     * "Emotes" a message into the channel.
     * {@inheritDoc}
     */
    public function emote($text)
    {
        return $this->important('channel', $text);
    }

    /**
     * Send a message to a user.
     * @param string $user user_id
     * {@inheritDoc}
     */
    public function tell($user, $text)
    {
        return $this->say(sprintf('[@%s] %s', $user, $text));
    }

    /**
     * Respond with a reply to a user.
     * @param CommandInterface|string user_id, or a CommandInterface containing user_id and user_name.
     * @param $text
     * @return Reply
     */
    public function reply($user, $text)
    {
        if ($user instanceof CommandInterface) {
            $user = (new SlackFormatter($user))->formatUserString();
            return $this->say($user.' '.$text);
        }

        return $this->tell($user, $text);
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

    /**
     * @param string $text
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    function shout($text)
    {
        return $this->important('everyone', $text);
    }

    /**
     * @param string $where
     * @param string $text
     * @return string
     */
    protected function important($where, $text)
    {
        return $this->say(sprintf('[!%s] %s', $where, $text));
    }
}
