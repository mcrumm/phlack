<?php

namespace spec\Crummy\Phlack;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageSpec extends ObjectBehavior
{
    const TEXT    = 'contents';
    const CHANNEL = 'channel';

    function let()
    {
        $this->beConstructedWith(self::TEXT);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message');
    }

    function it_contains_text()
    {
        $this->getText()->shouldReturn(self::TEXT);
    }

    function it_fluently_accepts_an_optional_channel()
    {
        $this->setChannel(self::CHANNEL)->shouldReturn($this);
    }

    function it_ensures_channel_begins_with_a_hash()
    {
        $withHash = '#'.self::CHANNEL;
        $this->setChannel(self::CHANNEL)->getChannel()->shouldReturn($withHash);
        $this->setChannel($withHash)->getChannel()->shouldReturn($withHash);
    }

    function it_prints_as_json()
    {
        $this
            ->setChannel(self::CHANNEL)
            ->__toString()
            ->shouldReturn(json_encode(array(
                'text'    => self::TEXT,
                'channel' => '#'.self::CHANNEL
            )))
        ;
    }
}
