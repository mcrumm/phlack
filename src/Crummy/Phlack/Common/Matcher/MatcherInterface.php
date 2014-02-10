<?php

namespace Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;

interface MatcherInterface
{
    /**
     * @param CommandInterface $command
     * @return boolean
     */
    public function matches(CommandInterface $command);
}
