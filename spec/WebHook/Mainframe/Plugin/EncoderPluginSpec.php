<?php

namespace spec\Crummy\Phlack\WebHook\Mainframe\Plugin;

use Crummy\Phlack\Common\Formatter\FormatterInterface;
use Crummy\Phlack\Message\Message;
use Crummy\Phlack\WebHook\Mainframe\Event;
use PhpSpec\ObjectBehavior;

class EncoderPluginSpec extends ObjectBehavior
{
    function let(FormatterInterface $formatter)
    {
        $this->beConstructedWith($formatter);
    }

    function it_is_a_Command_Plugin()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Mainframe\Plugin\EncoderPlugin');
        $this->shouldImplement('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_fires_after_the_command_is_executed(Event $event)
    {
        $this->onAfterExecute($event)->shouldReturn($event);
    }

    function it_encodes_the_output(FormatterInterface $formatter, Event $event, Message $message)
    {
        $unencoded = '<foo!> <#C01010|botgarage>';
        $encoded = '&lt;foo!&gt; <#C01010|botgarage>';

        $event->offsetExists('message')->willReturn(true);
        $event->offsetGet('message')->willReturn($message);

        $message->offsetExists('text')->willReturn(true);
        $message->offsetGet('text')->willReturn($unencoded);

        $formatter->format($unencoded)->willReturn($encoded);
        $message->offsetSet('text', $encoded)->shouldBeCalled();

        $this->onAfterExecute($event);
    }
}
