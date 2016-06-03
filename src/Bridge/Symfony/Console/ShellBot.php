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
     * {@inheritdoc}
     *
     * @param ConsoleAdapter $adapter Mediates between the Console IO and Phlack's Mainframe.
     */
    public function __construct($name = 'phlackbot', $version = 'UNKNOWN', ConsoleAdapter $adapter)
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
                $this->adapter->getName(),
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'The input command'),
        ]);

        return $inputDefinition;
    }
}
