<?php

namespace spec\Crummy\Phlack\Common\Formatter;

use PhpSpec\ObjectBehavior;

class EncodeFormatterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Formatter\EncodeFormatter');
        $this->shouldImplement('\Crummy\Phlack\Common\Formatter\FormatterInterface');
    }

    public function it_encodes_special_characters()
    {
        $this
            ->format('\'hello\' >< "world" &')
                ->shouldReturn('\'hello\' &gt;&lt; "world" &amp;');
    }

    public function it_does_not_encode_escaped_sequences()
    {
        $this
            ->format('<@U12345|crumm> Hello, & Good Morning <http://foo.com|foo>!')
            ->shouldReturn('<@U12345|crumm> Hello, &amp; Good Morning <http://foo.com|foo>!');
    }
}
