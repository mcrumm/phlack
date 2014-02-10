<?php

namespace spec\Crummy\Phlack\Bot\Mainframe;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CpuSpec extends ObjectBehavior
{
    function it_is_an_event_dispatcher()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\Mainframe\Cpu');
        $this->shouldImplement('\Symfony\Component\EventDispatcher\EventDispatcherInterface');
    }
}
