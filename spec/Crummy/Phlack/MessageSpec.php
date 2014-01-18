<?php

namespace spec\Crummy\Phlack;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('contents');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message');
    }

    function it_contains_text()
    {
        $this->getText()->shouldReturn('contents');
    }

    function it_prints_as_json()
    {
        $this->__toString()->shouldReturn(json_encode(array('text' => 'contents')));
    }
}
