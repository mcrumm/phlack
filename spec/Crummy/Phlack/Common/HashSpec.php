<?php

namespace spec\Crummy\Phlack\Common;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HashSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([ ]);
    }

    function it_is_an_encodable_guzzle_collection()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Hash');
        $this->shouldBeAnInstanceOf('\Guzzle\Common\Collection');
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    function it_cannot_be_instantiated_fromConfig()
    {
        $this->shouldThrow('\Crummy\Phlack\Common\Exception\RuntimeException')->during('fromConfig');
    }

    function it_echoes_a_json_hash()
    {
        $this->offsetSet('text', 'Hello!');
        $this->__toString()->shouldReturn('{"text":"Hello!"}');
    }

    function it_has_no_default_parameters()
    {
        $this->getDefaults()->shouldBe([]);
    }

    function it_has_no_optional_parameters()
    {
        $this->getOptional()->shouldBe([]);
    }

    function it_has_no_required_parameters()
    {
        $this->getRequired()->shouldBe([]);
    }
}
