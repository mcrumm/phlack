<?php

namespace Crummy\Phlack\WebHook;

interface WebHookInterface extends CommandInterface
{
    /**
     * @return float
     * @deprecated  Will be removed in 0.5.0
     */
    public function getTimestamp();
}
