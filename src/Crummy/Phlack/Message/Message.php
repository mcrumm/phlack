<?php

namespace Crummy\Phlack\Message;

class Message implements \JsonSerializable
{
    private $data;

    /**
     * @param $text
     * @param null $channel
     * @param null $username
     * @param null $iconEmoji
     */
    public function __construct($text, $channel = null, $username = null, $iconEmoji = null)
    {
        $this->data = array ('text' => $text);

        if ($channel)   { $this->setChannel($channel); }
        if ($username)  { $this->setUsername($username); }
        if ($iconEmoji) { $this->setIconEmoji($iconEmoji); }
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->data['text'];
    }

    /**
     * @param $channel
     * @return $this
     */
    public function setChannel($channel)
    {
        if (!empty($channel)) {
            $this->data['channel'] = (0 === strpos($channel, '#') ? $channel : '#' . $channel);
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChannel()
    {
        return isset($this->data['channel']) ? $this->data['channel'] : null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * @param $iconEmoji
     * @return $this
     */
    public function setIconEmoji($iconEmoji)
    {
        if (!empty($iconEmoji)) {
            $this->data['icon_emoji'] = sprintf(':%s:', trim($iconEmoji, ':'));
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIconEmoji()
    {
        return isset($this->data['icon_emoji']) ? $this->data['icon_emoji'] : null;
    }

    /**
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        if (!empty($username)) {
            $this->data['username'] = $username;
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername()
    {
        return isset($this->data['username']) ? $this->data['username'] : null;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array_filter($this->data);
    }
}
