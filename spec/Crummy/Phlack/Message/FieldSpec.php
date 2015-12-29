<?php

namespace spec\Crummy\Phlack\Message;

use PhpSpec\ObjectBehavior;

class FieldSpec extends ObjectBehavior
{
    public function let($title, $value, $isShort)
    {
        $this->beConstructedWith($title, $value, $isShort);
    }

    public function it_is_an_encodable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Field');
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    public function it_should_be_short()
    {
        $this['short'] = true;
        $this->shouldBeShort();
    }

    public function it_allows_false_as_a_value_for_short()
    {
        $this['short'] = false;
        $this->shouldNotBeShort();
    }
}
