<?php

namespace Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;

class NonMatcher implements MatcherInterface
{
    /**
     * @param CommandInterface $command
     * @return boolean
     */
    public function matches(CommandInterface $command)
    {
        return false;
    }
}
