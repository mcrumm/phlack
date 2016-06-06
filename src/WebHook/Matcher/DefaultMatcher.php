<?php

namespace Crummy\Phlack\WebHook\Matcher;

use Crummy\Phlack\WebHook\Command;

class DefaultMatcher implements MatcherInterface
{
    /**
     * @param Command $command
     *
     * @return bool
     */
    public function matches(Command $command)
    {
        return true;
    }
}
