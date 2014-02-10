<?php

namespace spec\Crummy\Phlack\WebHook\Reply;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmptyReplySpec extends ObjectBehavior
{
    function it_is_a_reply_hash()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Reply\EmptyReply');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\WebHook\Reply\Reply');
    }

    function its_default_is_empty_text()
    {
        $this->getDefaults()->shouldReturn([ 'text' => '' ]);
    }

    function its_text_is_immutable()
    {
        $this->offsetSet('text', 'Hello');
        $this->offsetGet('text')->shouldReturn('');
    }

    function its_toArray_method_should_only_return_text()
    {
        $this->offsetSet('text', 'Hello');
        $this->offsetSet('user', 'mcrumm');
        $this->toArray()->shouldReturn([ 'text' => '' ]);
    }
}
