<?php

namespace Crummy\Phlack\Message\Collection;

use Crummy\Phlack\Common\Collection\TypeCollection;
use Crummy\Phlack\Common\Encodable;

abstract class EncodableCollection extends TypeCollection implements Encodable
{
    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return array_filter($this->toArray());
    }
}
