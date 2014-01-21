<?php

namespace spec\Crummy\Phlack\Message;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FieldSpec extends ObjectBehavior
{
    function let($title, $value, $isShort) {
        $this->beConstructedWith($title, $value, $isShort);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Field');
    }

    function it_is_encodable()
    {
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    function it_provides_a_fluent_interface($title, $value, $short)
    {
        $this->setTitle($title)->shouldReturn($this);
        $this->setValue($value)->shouldReturn($this);
        $this->setShort($short)->shouldReturn($this);
    }

    function it_should_be_short()
    {
        $this->shouldBeShort();
    }

    function it_allows_false_as_a_value_for_short()
    {
        $this->setShort(false)->isShort()->shouldReturn(false);
    }
}
