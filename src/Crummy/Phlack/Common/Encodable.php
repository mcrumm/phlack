<?php

namespace Crummy\Phlack\Common;

interface Encodable extends \JsonSerializable
{
    public function __toString();
}
