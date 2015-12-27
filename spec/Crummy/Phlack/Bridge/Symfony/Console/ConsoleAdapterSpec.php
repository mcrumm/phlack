<?php

namespace spec\Crummy\Phlack\Bridge\Symfony\Console;

use Crummy\Phlack\Bot\Mainframe\Mainframe;
use Crummy\Phlack\Bot\Mainframe\Packet;
use Crummy\Phlack\WebHook\Converter\StringConverter;
use Crummy\Phlack\WebHook\Reply\Reply;
use Crummy\Phlack\WebHook\SlashCommand;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleAdapterSpec extends ObjectBehavior
{
    public function let(Mainframe $mainframe, StringConverter $converter)
    {
        $this->beConstructedWith($mainframe, $converter);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Symfony\Console\ConsoleAdapter');
    }

    public function it_executes_the_command_argument($mainframe, $converter, InputInterface $input, SlashCommand $cmd, OutputInterface $output, Packet $p)
    {
        $input->getArgument('command')->willReturn('/expr 2 + 2');
        $converter->convert('/expr 2 + 2')->willReturn($cmd);
        $mainframe->execute($cmd)->willReturn($p);
        $reply = new Reply('4');
        $p->offsetGet('output')->willReturn($reply);
        $output->writeln($reply->get('text'))->shouldBeCalled();
        $this->execute($input, $output);
    }
}
