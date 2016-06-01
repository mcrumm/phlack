<?php

namespace spec\Crummy\Phlack\Message;

use PhpSpec\ObjectBehavior;

class FieldSpec extends ObjectBehavior
{
    function let($title, $value, $isShort)
    {
        $this->beConstructedWith($title, $value, $isShort);
    }

    function it_is_an_encodable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Field');
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    function it_should_be_short()
    {
        $this['short'] = true;
        $this->shouldBeShort();
    }

    function it_allows_false_as_a_value_for_short()
    {
        $this['short'] = false;
        $this->shouldNotBeShort();
    }
}
