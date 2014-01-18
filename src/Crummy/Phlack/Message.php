<?php

namespace Crummy\Phlack;

class Message
{
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function __toString()
    {
        return json_encode(array('text' => $this->text));
    }
}
