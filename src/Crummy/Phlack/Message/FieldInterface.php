<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\Encodable;

interface FieldInterface extends Encodable
{
    /**
     * @return bool
     */
    public function isShort();
}
