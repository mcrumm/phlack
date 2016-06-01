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

    function it_converts_commands_to_slash_commands()
    {
        $this->convert('/foo bar')->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\SlashCommand');
    }

    function it_converts_non_commands_to_webhooks()
    {
        $this->convert('foo: bar')->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\WebHook');
    }
}
