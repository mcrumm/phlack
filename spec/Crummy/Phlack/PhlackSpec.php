<?php

namespace spec\Crummy\Phlack;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhlackSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('the_username', 'the_token');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Phlack');
    }

    function it_take_two_parameters_and_returns_a_phlack_object()
    {
        $this->beAnInstanceOf('Crummy\Phlack\Phlack');
    }

    function it_should_return_the_username()
    {
        $this->getUsername()->shouldBeString();
    }

    function it_should_return_the_token()
    {
        $this->getToken()->shouldBeString();
    }
}
