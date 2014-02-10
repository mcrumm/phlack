<?php

namespace Crummy\Phlack\WebHook;

interface WebHookInterface extends CommandInterface
{
    /**
     * @return float
     */
    public function getTimestamp();
}
