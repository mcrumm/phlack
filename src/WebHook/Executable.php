<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Encodable;

interface Executable
{
    /**
     * @param CommandInterface $command
     *
     * @return Encodable
     */
    public function execute(CommandInterface $command);
}
