<?php

namespace spec\Crummy\Phlack\Builder;

use Crummy\Phlack\Message\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Builder\MessageBuilder');
    }

    function it_is_a_builder()
    {
        $this->shouldImplement('\Crummy\Phlack\Builder\BuilderInterface');
    }

    function it_fails_on_empty_text()
    {
        $this->shouldThrow('\LogicException')->during('create');
    }

    function it_returns_a_message_on_create()
    {
        $this->setText('Message')->create()->shouldReturnAnInstanceOf('\Crummy\Phlack\Message\Message');
    }

    function it_fluently_sets_vars()
    {
        $this->setText('text')->shouldReturn($this);
        $this->setChannel('channel')->shouldReturn($this);
        $this->setIconEmoji('package')->shouldReturn($this);
        $this->setUsername('user')->shouldReturn($this);
    }

    function it_refreshes_data_on_create()
    {
        $message_1 = $this->setText('Message #1')->setChannel('1')->create();

        /** @var Message $message_2 */
        $message_2 = $this->setText('Message #2')->create();
        $message_2->getChannel()->shouldBeNull();
    }
}
