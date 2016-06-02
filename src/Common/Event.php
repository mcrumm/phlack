<?php

namespace Crummy\Phlack\Common;

use Guzzle\Common\Event as GuzzleEvent;
use JsonSerializable;

class Event extends GuzzleEvent implements Encodable
{
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this['message'] && $this['message'] instanceof JsonSerializable
            ? $this['message']->jsonSerialize()
            : $this['message']
        ;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }
}
