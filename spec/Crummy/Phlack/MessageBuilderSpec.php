<?php

namespace spec\Crummy\Phlack;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\MessageBuilder');
    }

    function it_is_a_builder()
    {
        $this->shouldImplement('\Crummy\Phlack\Message\BuilderInterface');
    }

    function it_fails_on_empty_text()
    {
        $this->shouldThrow('\LogicException')->during('create');
    }

    function it_fluently_sets_vars()
    {
        $this->setText('text')->shouldReturn($this);
        $this->setChannel('channel')->shouldReturn($this);
        $this->setIconEmoji('package')->shouldReturn($this);
        $this->setUsername('user')->shouldReturn($this);
    }
}
