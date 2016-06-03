<?php

namespace spec\Crummy\Phlack\Bridge\Symfony\Console;

use Crummy\Phlack\Bot\ExpressionBot;
use Crummy\Phlack\WebHook\Mainframe;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleAdapterSpec extends ObjectBehavior
{
    function let()
    {
        $mf = new Mainframe();
        $mf->attach(new ExpressionBot('/math'));

        $this->beConstructedWith($mf);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Symfony\Console\ConsoleAdapter');
    }

    function it_executes_the_command_argument(InputInterface $input, OutputInterface $output)
    {
        $input
            ->getArgument('command')
            ->shouldBeCalled()
            ->willReturn('/math 2+2')
        ;

        $output
            ->writeln('4')
            ->shouldBeCalled()
        ;

        $this->execute($input, $output);
    }
}
