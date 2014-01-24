<?php

namespace Crummy\Phlack\Builder;

use Crummy\Phlack\Message\Message;

class MessageBuilder implements BuilderInterface
{
    private $data;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->refresh();
    }

    /**
     * @throws \LogicException When create is called before text has been set
     */
    public function create()
    {
        if (empty($this->data['text'])) {
            throw new \LogicException('Message text cannot be empty.');
        }

        $data = $this->data;

        $this->refresh();

        return new Message($data['text'], $data['channel'], $data['username'], $data['icon_emoji']);
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->data['text'] = $text;
        return $this;
    }

    /**
     * @param $channel
     * @return $this
     */
    public function setChannel($channel)
    {
        $this->data['channel'] = $channel;
        return $this;
    }

    /**
     * @param $iconEmoji
     * @return $this
     */
    public function setIconEmoji($iconEmoji)
    {
        $this->data['icon_emoji'] = $iconEmoji;
        return $this;
    }

    /**
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->data['username'] = $username;
        return $this;
    }

    /**
     * Reset data to an empty message
     */
    protected function refresh()
    {
        $this->data = [
            'text'       => null,
            'channel'    => null,
            'username'   => null,
            'icon_emoji' => null,
        ];
    }
}
