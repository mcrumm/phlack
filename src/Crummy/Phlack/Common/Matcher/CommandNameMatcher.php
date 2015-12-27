<?php

namespace Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;

class CommandNameMatcher implements MatcherInterface
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
     *
     * @return bool
     */
    public function matches(CommandInterface $command)
    {
        return $this->getCommandName() === $command->get('command');
    }

    /**
     * @param $command
     *
     * @return $this
     */
    public function setCommandName($command)
    {
        $this->commandName = $command;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCommandName()
    {
        return $this->commandName;
    }
}
