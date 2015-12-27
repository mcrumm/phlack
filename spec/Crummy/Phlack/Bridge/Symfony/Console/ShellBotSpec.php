<?php

namespace spec\Crummy\Phlack\Bridge\Symfony\Console;

use PhpSpec\ObjectBehavior;

class ShellBotSpec extends ObjectBehavior
{
    public function it_is_a_console_application()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Symfony\Console\ShellBot');
        $this->shouldBeAnInstanceOf('\Symfony\Component\Console\Application');
    }

    public function its_definition_calls_for_a_single_command_argument()
    {
        /** @var \Symfony\Component\Console\Input\InputDefinition $definition */
        $definition = $this->getDefinition();

        $definition->hasArgument('command')->shouldReturn(true);
        $definition->getArguments()->shouldHaveCount(1);
    }
}
