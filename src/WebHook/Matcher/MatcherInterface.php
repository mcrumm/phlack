<?php

namespace Crummy\Phlack\WebHook\Matcher;

use Crummy\Phlack\WebHook\Command;

interface MatcherInterface
{
    /**
     * @param Command $command
     *
     * @return bool
     */
    public function matches(Command $command);
}
