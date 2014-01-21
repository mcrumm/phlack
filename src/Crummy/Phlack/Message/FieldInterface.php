<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\Encodable;

interface FieldInterface extends Encodable
{
    /**
     * @return boolean
     */
    public function isShort();
}
