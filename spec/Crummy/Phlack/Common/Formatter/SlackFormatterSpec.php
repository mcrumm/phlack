<?php

namespace spec\Crummy\Phlack\Common\Formatter;

use Crummy\Phlack\Message\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlackFormatterSpec extends ObjectBehavior
{
    function let(Message $message)
    {
        $this->beConstructedWith($message);
    }

    function it_is_a_message_formatter()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Formatter\SlackFormatter');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Common\Formatter\AbstractFormatter');
    }

    function it_encodes_htmlspecialchars_but_no_quotes(Message $message)
    {
        $message->jsonSerialize()->willReturn([ 'text' => '<foo> & \'bar\'' ]);
        $this->jsonSerialize()['text']->shouldBeLike('&lt;foo&gt; &amp; \'bar\'');
    }
}
