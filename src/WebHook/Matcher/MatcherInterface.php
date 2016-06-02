<?php

namespace Crummy\Phlack\WebHook\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;

interface MatcherInterface
{
    /**
     * @param CommandInterface $command
     *
     * @return bool
     */
    public function matches(CommandInterface $command);
}
