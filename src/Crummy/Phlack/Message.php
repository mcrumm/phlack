<?php

namespace Crummy\Phlack;

class Message
{
    private $data;

    /**
     * @param string $text
     */
    public function __construct($text)
    {
        $this->data = array (
            'text' => $text
        );
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
        return $this->data['channel'];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode(array_filter($this->data));
    }
}
