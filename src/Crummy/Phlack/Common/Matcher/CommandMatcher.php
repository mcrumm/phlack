<?php

namespace Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\SlashCommand;

class CommandMatcher implements MatcherInterface
{
    protected $commandName;

    /**
     * @param string|null $commandName
     */
    public function __construct($commandName = null)
    {
        $this->commandName = $commandName;
    }

    /**
     * @param CommandInterface $command
     * @return boolean
     */
    public function matches(CommandInterface $command)
    {
        return null === $this->commandName
            ? $command instanceof SlashCommand
            : $command instanceof SlashCommand && $command->getCommand() === $this->commandName;
    }

    /**
     * @param $command
     * @return $this
     */
    public function setCommandName($command)
    {
        $this->commandName = $command;
        return $this;
    }

    public function getCommandName()
    {
        return $this->commandName;
    }
}
