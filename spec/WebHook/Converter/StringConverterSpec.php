<?php

namespace spec\Crummy\Phlack\WebHook\Converter;

use PhpSpec\ObjectBehavior;

class StringConverterSpec extends ObjectBehavior
{
    function it_is_a_converter()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Converter\StringConverter');
        $this->shouldImplement('\Crummy\Phlack\WebHook\Converter\ConverterInterface');
    }

    function it_converts_commands()
    {
        $this->convert('/foo bar')->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\Command');
    }

    function it_can_be_invoked_for_slash_commands()
    {
        $this->__invoke('/foo bar')->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\Command');
    }

    function it_converts_outgoing_webhooks()
    {
        $this->convert('foo: bar')->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\Command');
    }

    function it_can_be_invoked_for_an_outgoing_webhook()
    {
        $this->__invoke('foo: bar')->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\Command');
    }
}
