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

    public function it_cannot_be_instantiated_fromConfig()
    {
        $this->shouldThrow('\Crummy\Phlack\Common\Exception\RuntimeException')->during('fromConfig');
    }

    public function it_echoes_a_json_hash()
    {
        $this->offsetSet('text', 'Hello!');
        $this->__toString()->shouldReturn('{"text":"Hello!"}');
    }

    public function it_has_no_default_parameters()
    {
        $this->getDefaults()->shouldBe([]);
    }

    public function it_has_no_optional_parameters()
    {
        $this->getOptional()->shouldBe([]);
    }

    public function it_has_no_required_parameters()
    {
        $this->getRequired()->shouldBe([]);
    }
}
