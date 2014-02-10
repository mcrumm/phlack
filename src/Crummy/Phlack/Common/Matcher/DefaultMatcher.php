<?php

namespace Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;

class DefaultMatcher implements MatcherInterface
{
    /**
     * @param CommandInterface $command
     * @return boolean
     */
    public function matches(CommandInterface $command)
    {
        return true;
    }
}
