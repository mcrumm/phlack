<?php

namespace Crummy\Phlack\WebHook\Matcher;

use Crummy\Phlack\WebHook\Command;

class CommandMatcher implements MatcherInterface
{
    /**
     * @var null|string
     */
    protected $commandName;

    /**
     * CommandMatcher constructor.
     *
     * @param null|string $commandName
     */
    public function __construct($commandName = null)
    {
        $this->commandName = $commandName;
    }

    /**
     * @param Command $command
     *
     * @return bool
     */
    public function matches(Command $command)
    {
        return null === $this->commandName
            ? isset($command['command'])
            : isset($command['command']) && $command['command'] === $this->commandName;
    }
}
