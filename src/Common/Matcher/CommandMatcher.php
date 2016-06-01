<?php

namespace Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\SlashCommand;

class CommandMatcher extends CommandNameMatcher
{
    /**
     * {@inheritdoc}
     */
    public function matches(CommandInterface $command)
    {
        return null === $this->commandName
            ? $command instanceof SlashCommand
            : $command instanceof SlashCommand && parent::matches($command);
    }
}
