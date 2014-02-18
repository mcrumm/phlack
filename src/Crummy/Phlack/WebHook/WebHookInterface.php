<?php

namespace Crummy\Phlack\WebHook;

interface WebHookInterface extends CommandInterface
{
    /**
     * @return float
     * @deprecated Will be removed in 0.6.0
     */
    public function getTimestamp();
}
