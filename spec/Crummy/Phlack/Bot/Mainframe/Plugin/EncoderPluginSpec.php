<?php

namespace spec\Crummy\Phlack\Bot\Mainframe\Plugin;

use Crummy\Phlack\Bot\Mainframe\Packet;
use Crummy\Phlack\Common\Formatter\FormatterInterface;
use Crummy\Phlack\WebHook\Reply\Reply;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EncoderPluginSpec extends ObjectBehavior
{
    function let(FormatterInterface $formatter)
    {
        $this->beConstructedWith($formatter);
    }

    function it_is_a_Mainframe_Plugin()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\Mainframe\Plugin\EncoderPlugin');
        $this->shouldImplement('\Crummy\Phlack\Bot\Mainframe\Plugin\PluginInterface');
    }

    function it_fires_after_the_command_is_executed(Packet $packet)
    {
        $this->onAfterExecute($packet)->shouldReturn($packet);
    }

    function it_encodes_the_output(FormatterInterface $formatter, Packet $packet, Reply $reply)
    {
        $unencoded = '<foo!> <#C01010|botgarage>';
        $encoded   = '&lt;foo!&gt; <#C01010|botgarage>';

        $packet->offsetExists('output')->willReturn(true);
        $packet->offsetGet('output')->willReturn($reply);

        $reply->offsetExists('text')->willReturn(true);
        $reply->offsetGet('text')->willReturn($unencoded);

        $formatter->format($unencoded)->willReturn($encoded);
        $reply->offsetSet('text', $encoded)->shouldBeCalled();

        $this->onAfterExecute($packet);
    }
}
