<?php

namespace Crummy\Phlack\WebHook\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;

class NonMatcher implements MatcherInterface
{
    /**
     * @param CommandInterface $command
     *
     * @return bool
     */
    public function matches(CommandInterface $command)
    {
        return false;
    }
}
