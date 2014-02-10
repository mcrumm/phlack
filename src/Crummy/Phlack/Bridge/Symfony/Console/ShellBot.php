<?php

namespace Crummy\Phlack\Bridge\Symfony\Console;

use Crummy\Phlack\Bot\Mainframe\Mainframe;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

class ShellBot extends Application
{
    private $bot;

    /**
     * {@inheritDoc}
     * @param BotCommand $botCommand The BotCommand that executes for this ShellBot.
     */
    public function __construct($name = 'phlackbot', $version = 'UNKNOWN', BotCommand $botCommand = null)
    {
        $this->bot = $botCommand ?: new BotCommand(new ConsoleAdapter(new Mainframe()));
        parent::__construct($name, $version);
    }

    /**
     * Overrides commandName for this ShellBot.
     * {@inheritDoc}
     */
    protected function getCommandName(InputInterface $input)
    {
        return $this->bot->getName();
    }

    /**
     * Adds BotCommand as the sole command for this ShellBot.
     * {@inheritDoc}
     */
    protected function getDefaultCommands()
    {
        $defaultCommands   = parent::getDefaultCommands();
        $defaultCommands[] = $this->bot;
        return $defaultCommands;
    }

    /**
     * Replaces the default InputDefinition with one containing only the 'command' argument.
     * {@inheritDoc}
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments(array(
            new InputArgument('command', InputArgument::OPTIONAL|InputArgument::IS_ARRAY, 'The input command')
        ));
        return $inputDefinition;
    }
}