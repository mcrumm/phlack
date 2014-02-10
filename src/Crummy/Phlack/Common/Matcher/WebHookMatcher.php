<?php

namespace Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\WebHookInterface;

class WebHookMatcher extends CommandMatcher
{
    /**
     * {@inheritDoc}
     */
    public function matches(CommandInterface $command)
    {
        return $command instanceof WebHookInterface;
    }
}
