<?php

namespace spec\Crummy\Phlack\Message;

use Crummy\Phlack\Message\AttachmentInterface;
use Crummy\Phlack\Message\Collection\AttachmentCollection;
use PhpSpec\ObjectBehavior;

class MessageSpec extends ObjectBehavior
{
    const TEXT = 'contents';
    const CHANNEL = 'channel';
    const ICON_EMOJI = 'cookie';
    const USERNAME = 'crumm';

    public function let()
    {
        $this->beConstructedWith(self::TEXT);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Message');
        $this->shouldImplement('\Crummy\Phlack\Message\MessageInterface');
    }

    public function it_contains_text()
    {
        $this->offsetGet('text')->shouldReturn(self::TEXT);
    }

    public function it_allows_for_direct_messages_in_channel()
    {
        $this->beConstructedWith(self::TEXT, '@mcrumm');

        $this->offsetGet('channel')->shouldBe('@mcrumm');
    }

    public function it_does_not_alter_passed_channel()
    {
        $this->beConstructedWith(self::TEXT, ':channel_id');

        $this->offsetGet('channel')->shouldBe(':channel_id');
    }

    public function it_wraps_icon_emoji_in_colons_on_construct()
    {
        $wrapped = ':'.self::ICON_EMOJI.':';

        $this->beConstructedWith(self::TEXT, self::CHANNEL, self::USERNAME, self::ICON_EMOJI);

        $this->offsetGet('icon_emoji')->shouldBe($wrapped);
    }

    public function it_does_not_double_wrap_the_icon_emoji()
    {
        $wrapped = ':'.self::ICON_EMOJI.':';

        $this->beConstructedWith(self::TEXT, self::CHANNEL, self::USERNAME, $wrapped);

        $this->offsetGet('icon_emoji')->shouldBe($wrapped);
    }

    public function it_prints_as_json()
    {
        $this->beConstructedWith(self::TEXT, self::CHANNEL);

        $this
            ->__toString()
            ->shouldReturn(json_encode([
                'text'        => self::TEXT,
                'channel'     => self::CHANNEL,
            ]));
    }

    public function it_returns_an_attachment_collection()
    {
        $this->getAttachments()->shouldBeAnInstanceOf('\Crummy\Phlack\Message\Collection\AttachmentCollection');
    }

    public function it_increments_the_field_count_on_add(AttachmentInterface $attachment)
    {
        $this->addAttachment($attachment);
        $this['attachments']->shouldHaveCount(1);
    }

    public function it_adds_attachments_to_serialized_output(AttachmentCollection $attachments, AttachmentInterface $attachment)
    {
        $this->addAttachment($attachment);
        $this->jsonSerialize()['attachments']->shouldHaveCount(1);
    }

    public function it_does_not_add_attachments_if_empty(AttachmentCollection $attachments)
    {
        $attachments->count()->shouldBeCalled();
        $attachments->jsonSerialize()->shouldNotBeCalled();

        $this->offsetSet('attachments', $attachments);

        $this->jsonSerialize();
    }
}
