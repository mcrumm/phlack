<?php

namespace Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\WebHookInterface;

class WebHookMatcher extends CommandNameMatcher
{
    /**
     * {@inheritdoc}
     */
    public function matches(CommandInterface $command)
    {
        return null === $this->commandName
            ? $command instanceof WebHookInterface
            : $command instanceof WebHookInterface && parent::matches($command);
    }
}
