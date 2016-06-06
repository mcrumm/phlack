<?php

namespace spec\Crummy\Phlack\Bridge\Symfony\Console;

use Crummy\Phlack\Bridge\Symfony\Console\ConsoleAdapter;
use Crummy\Phlack\WebHook\Mainframe;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShellBotSpec extends ObjectBehavior
{
    function let()
    {
        $adapter = new ConsoleAdapter(new Mainframe());

        $this->beConstructedWith($adapter, 'shellbot', 'spec');
    }

    function it_is_a_console_application()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Symfony\Console\ShellBot');
        $this->shouldBeAnInstanceOf('\Symfony\Component\Console\Application');
    }

    function its_definition_calls_for_a_single_command_argument()
    {
        $this
            ->getDefinition()
            ->getArguments()
            ->shouldHaveCount(1)
        ;
    }
}
