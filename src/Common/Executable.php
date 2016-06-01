<?php

namespace Crummy\Phlack\Common;

use Crummy\Phlack\WebHook\CommandInterface;

interface Executable
{
    /**
     * @param CommandInterface $command
     *
     * @return \Crummy\Phlack\Common\Encodable
     */
    public function execute(CommandInterface $command);
}
