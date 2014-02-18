<?php

namespace spec\Crummy\Phlack\Common\Formatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EncodeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Formatter\EncodeFormatter');
        $this->shouldImplement('\Crummy\Phlack\Common\Formatter\FormatterInterface');
    }

    function it_encodes_special_characters()
    {
        $this
            ->format('\'hello\' >< "world" &')
                ->shouldReturn('\'hello\' &gt;&lt; "world" &amp;')
        ;
    }

    function it_does_not_encode_escaped_sequences()
    {
        $this
            ->format('<@U12345|crumm> Hello, & Good Morning <http://foo.com|foo>!')
            ->shouldReturn('<@U12345|crumm> Hello, &amp; Good Morning <http://foo.com|foo>!');
    }
}
