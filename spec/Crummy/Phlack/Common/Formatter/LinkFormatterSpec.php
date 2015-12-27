<?php

namespace spec\Crummy\Phlack\Common\Formatter;

use PhpSpec\ObjectBehavior;

class LinkFormatterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Formatter\LinkFormatter');
        $this->shouldImplement('\Crummy\Phlack\Common\Formatter\FormatterInterface');
    }

    public function it_formats_html_links()
    {
        $this
            ->format('Hello, <a href="http://example.com/">link</a> is an example in HTML.')
                ->shouldContain('<http://example.com/|link>');
    }

    public function it_formats_markdown_links()
    {
        $this
            ->format('Hello, [link](http://example.com/) is an example in Markdown.')
                ->shouldContain('<http://example.com/|link>');
    }

    public function it_formats_markdown_links_without_title()
    {
        $this
            ->format('Hello, [](http://example.com/) is another example in Markdown.')
                ->shouldContain('<http://example.com/>');
    }

    public function getMatchers()
    {
        return [
            'contain' => function ($haystack, $needle) {
                return false !== strpos($haystack, $needle);
            },
        ];
    }
}
