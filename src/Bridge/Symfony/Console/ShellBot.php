<?php

namespace Crummy\Phlack\Bridge\Symfony\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

class ShellBot extends Application
{
    /**
     * @var ConsoleAdapter
     */
    private $adapter;

    /**
     * ShellBot constructor.
     *
     * @param ConsoleAdapter $adapter Mediates between the Console IO and Phlack's Mainframe.
     * @param string         $name
     * @param string         $version
     */
    public function __construct(ConsoleAdapter $adapter, $name = 'phlackbot', $version = 'UNKNOWN')
    {
        $this->adapter = $adapter;

        parent::__construct($name, $version);
    }

    /**
     * Overrides commandName for this ShellBot.
     * {@inheritdoc}
     */
    protected function getCommandName(InputInterface $input)
    {
        return $this->adapter->getName();
    }

    /**
     * Adds ConsoleAdapter as the sole command for this ShellBot.
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = $this->adapter;

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
            new InputArgument(
                'command',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'The input command'),
        ]);

        return $inputDefinition;
    }
}
