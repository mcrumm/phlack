<?php

namespace spec\Crummy\Phlack\Common;

use PhpSpec\ObjectBehavior;

class HashSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([]);
    }

    public function it_is_an_encodable_guzzle_collection()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Hash');
        $this->shouldBeAnInstanceOf('\Guzzle\Common\Collection');
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    public function it_can_be_instantiated_fromConfig()
    {
        $this->beConstructedThrough('fromConfig', [[]]);

        $this->toArray()->shouldBe([]);
    }

    public function it_does_not_support_defaults_fromConfig()
    {
        $this->shouldThrow('\LogicException')->duringFromConfig([], ['foo' => 'bar']);
    }

    public function it_does_not_support_required_fromConfig()
    {
        $this->shouldThrow('\LogicException')->duringFromConfig([], [], ['foo' => 'bar']);
    }

    public function it_echoes_a_json_hash()
    {
        $this->offsetSet('text', 'Hello!');
        $this->__toString()->shouldReturn('{"text":"Hello!"}');
    }

    public function it_has_no_defined_parameters()
    {
        $this->jsonSerialize()->shouldBe([]);
    }
}
