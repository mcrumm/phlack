<?php

namespace Crummy\Phlack;

class Message
{
    private $data;

    public function __construct($text)
    {
        $this->data = array (
            'text' => $text
        );
    }

    public function getText()
    {
        return $this->data['text'];
    }

    public function setChannel($channel)
    {
        if (!empty($channel)) {
            $this->data['channel'] = (0 === strpos($channel, '#') ? $channel : '#' . $channel);
        }
        return $this;
    }

    public function getChannel()
    {
        return $this->data['channel'];
    }

    public function __toString()
    {
        return json_encode(array_filter($this->data));
    }
}
