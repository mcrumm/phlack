<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Encodable;
use Guzzle\Common\ToArrayInterface;

/**
 * CommandInterface.
 */
interface CommandInterface extends Encodable, \ArrayAccess, ToArrayInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);
}
