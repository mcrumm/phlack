<?php

namespace Crummy\Phlack;

use Crummy\Phlack\Message\BuilderInterface;

class MessageBuilder implements BuilderInterface
{
    private $data = [];

    /**
     * @throws \LogicException When create is called before text has been set
     */
    public function create()
    {
        if (empty($this->data['text'])) {
            throw new \LogicException('Message text cannot be empty.');
        }

        return new Message\Message(
            $this->data['text'],
            isset($this->data['channel']) ? $this->data['channel'] : null,
            isset($this->data['username']) ? $this->data['username'] : null,
            isset($this->data['icon_emoji']) ? $this->data['icon_emoji'] : null
        );
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
}
