<?php

namespace spec\Crummy\Phlack\WebHook;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Command');
    }

    function it_is_can_be_converted_to_JSON()
    {
        $data = ['command' => '/foo', 'text' => 'bar!'];

        $this->beConstructedWith($data);

        $this->jsonSerialize()->shouldReturn($data);
    }

    function it_can_be_encoded_as_a_string()
    {
        $data = ['command' => '/foo', 'text' => 'bar!'];

        $this->beConstructedWith($data);

        $this->__toString()->shouldReturn(json_encode($data));
    }
}
