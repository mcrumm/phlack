<?php

namespace Crummy\Phlack\Hook;

use Crummy\Phlack\Common\Encodable;

interface HookInterface extends Encodable
{
    /**
     * @return array
     */
    static public function getRequiredFields();
}
