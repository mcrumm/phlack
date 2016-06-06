<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Encodable;

class Command extends \ArrayObject implements Encodable
{
    /**
     * @return array
     */
    function jsonSerialize()
    {
        return $this->getArrayCopy();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }
}
