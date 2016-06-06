<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Encodable;

interface Executable
{
    /**
     * @param Command $command
     *
     * @return Encodable
     */
    public function execute(Command $command);
}
