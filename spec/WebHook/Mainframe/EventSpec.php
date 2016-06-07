<?php

namespace spec\Crummy\Phlack\WebHook\Mainframe;

use Crummy\Phlack\Message\Message;
use PhpSpec\ObjectBehavior;

class EventSpec extends ObjectBehavior
{
    function it_is_a_Guzzle_Event()
    {
        $this->shouldBeAnInstanceOf('\Guzzle\Common\Event');
    }

    function it_is_encodable()
    {
        $this->beConstructedWith(['message' => new Message('foo!')]);
        $this->__toString()->shouldBe(json_encode(['text' => 'foo!']));
    }

    function it_serializes_its_message()
    {
        $this->offsetSet('message', new Message('hello, world!'));

        $this->jsonSerialize()->shouldBe([
            'text' => 'hello, world!'
        ]);
    }
}
