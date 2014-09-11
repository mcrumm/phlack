<?php

namespace Crummy\Phlack\Common;

interface Encodable extends \JsonSerializable
{
    /**
     * @return string
     */
    public function __toString();
}
