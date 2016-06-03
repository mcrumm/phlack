<?php

namespace spec\Crummy\Phlack\Bridge\Symfony\Console;

use Crummy\Phlack\Bot\BotInterface;
use Crummy\Phlack\Bridge\Symfony\Console\ConsoleAdapter;
use Crummy\Phlack\WebHook\Mainframe;
use PhpSpec\ObjectBehavior;

class BotCommandSpec extends ObjectBehavior
{
    function let(ConsoleAdapter $adapter)
    {
        $this->beConstructedWith($adapter);
    }

    function it_is_a_console_command()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Symfony\Console\BotCommand');
        $this->shouldImplement('\Symfony\Component\Console\Command\Command');
    }

    function it_is_a_proxy_for_ConsoleAdapter_getConverter(ConsoleAdapter $adapter)
    {
        $adapter->getConverter()->shouldBeCalled();
        $this->getConverter();
    }

    function it_is_a_proxy_for_ConsoleAdapter_attach(ConsoleAdapter $adapter, BotInterface $bot)
    {
        $adapter->attach($bot, null, 0)->shouldBeCalled();
        $this->attach($bot);
    }

    function it_fluently_sets_mainframe_on_the_adapter(ConsoleAdapter $adapter, Mainframe $mainframe)
    {
        $adapter->setMainframe($mainframe)->shouldBeCalled();
        $this->setMainframe($mainframe)->shouldReturn($this);
    }
}
