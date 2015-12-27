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
     * {@inheritdoc}
     *
     * @param BotCommand $botCommand The BotCommand that executes for this ShellBot.
     */
    public function __construct($name = 'phlackbot', $version = 'UNKNOWN', BotCommand $botCommand = null)
    {
        $this->bot = $botCommand ?: new BotCommand(new ConsoleAdapter(new Mainframe()));
        parent::__construct($name, $version);
    }

    /**
     * Overrides commandName for this ShellBot.
     * {@inheritdoc}
     */
    protected function getCommandName(InputInterface $input)
    {
        return $this->bot->getName();
    }

    /**
     * Adds BotCommand as the sole command for this ShellBot.
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = $this->bot;

        return $defaultCommands;
    }

    /**
     * Replaces the default InputDefinition with one containing only the 'command' argument.
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments([
            new InputArgument('command', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'The input command'),
        ]);

        return $inputDefinition;
    }
}
