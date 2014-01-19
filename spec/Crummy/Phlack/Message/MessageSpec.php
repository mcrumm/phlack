<?php

namespace spec\Crummy\Phlack\Message;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageSpec extends ObjectBehavior
{
    const TEXT       = 'contents';
    const CHANNEL    = 'channel';
    const ICON_EMOJI = 'cookie';
    const USERNAME   = 'crumm';

    function let()
    {
        $this->beConstructedWith(self::TEXT);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Message');
    }

    function it_is_json_serializable()
    {
        $this->shouldImplement('\JsonSerializable');
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

    function it_fluently_accepts_an_icon_emoji()
    {
        $this->setIconEmoji(self::ICON_EMOJI)->shouldReturn($this);
    }

    function it_wraps_icon_emoji_in_colons()
    {
        $wrapped = ':'.self::ICON_EMOJI.':';

        $this
            ->setIconEmoji(self::ICON_EMOJI)
            ->getIconEmoji()
                ->shouldReturn($wrapped);

        $this
            ->setIconEmoji($wrapped)
            ->getIconEmoji()
                ->shouldReturn($wrapped);
    }

    function it_fluently_accepts_an_username()
    {
        $this->setUsername(self::USERNAME)->shouldReturn($this);
        $this->getUsername()->shouldReturn(self::USERNAME);
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
