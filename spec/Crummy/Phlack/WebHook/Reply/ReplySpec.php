<?php

namespace spec\Crummy\Phlack\WebHook\Reply;

use PhpSpec\ObjectBehavior;

class ReplySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Reply\Reply');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Common\Hash');
    }

    public function it_defaults_to_empty_text()
    {
        $this->toArray()->shouldReturn(['text' => '']);
    }

    public function it_stores_text_in_the_array()
    {
        $this->offsetSet('text', 'ok');
        $this->toArray()->shouldReturn(['text' => 'ok']);
    }

    public function it_only_serializes_text()
    {
        $this->offsetSet('text', 'bar');
        $this->offsetSet('channel', 'foo');
        $this->jsonSerialize()->shouldReturn(['text' => 'bar']);
    }

    public function it_only_echoes_text()
    {
        $this->offsetSet('text', 'ok');
        $this->offsetSet('iconEmoji', 'ghost');
        $this->__toString()->shouldReturn('{"text":"ok"}');
    }
}
