<?php

namespace spec\Crummy\Phlack\Common\Formatter;

use Crummy\Phlack\Common\Formatter\EncodeFormatter;
use Crummy\Phlack\Common\Formatter\LinkFormatter;
use PhpSpec\ObjectBehavior;

class FormatterCollectionSpec extends ObjectBehavior
{
    public function let(LinkFormatter $linker, EncodeFormatter $encoder)
    {
        $this->beConstructedWith([$linker, $encoder]);
    }

    public function it_is_a_formatter()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Formatter\FormatterCollection');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Common\Collection\TypeCollection');
        $this->shouldImplement('\Crummy\Phlack\Common\Formatter\FormatterInterface');
    }

    public function its_format_is_a_composite_of_all_internal_formatters($linker, $encoder)
    {
        $text = 'Hello, <@U1|user>. Do you like fun & [games](http://example.com)?';

        $after_linker = 'Hello, <@U1|user>. Do you like fun & <http://example.com|games>?';
        $linker->format($text)->willReturn($after_linker);

        $after_encoder = 'Hello, <@U1|user>. Do you like fun &amp; <http://example.com|games>?';
        $encoder->format($after_linker)->willReturn($after_encoder);

        $this->format($text)->shouldReturn($after_encoder);
    }
}
