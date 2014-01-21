<?php

namespace spec\Crummy\Phlack\Message;

use Crummy\Phlack\Message\Attachment;
use Crummy\Phlack\Message\AttachmentInterface;
use Crummy\Phlack\Message\Field;
use Crummy\Phlack\Message\Collection\AttachmentCollection;
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

    function it_is_encodable()
    {
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
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
            ->shouldReturn(json_encode([
                'text'        => self::TEXT,
                'channel'     => '#'.self::CHANNEL
            ]))
        ;
    }

    function it_adds_attachments_to_the_collection(AttachmentCollection $attachments, AttachmentInterface $attachment)
    {
        $attachments->add($attachment)->shouldBeCalled();

        $this->setAttachments($attachments);
        $this->addAttachment($attachment);
    }

    function it_returns_an_attachment_collection()
    {
        $this->getAttachments()->shouldBeAnInstanceOf('\Crummy\Phlack\Message\Collection\AttachmentCollection');
    }

    function it_increments_the_field_count_on_add(AttachmentInterface $attachment)
    {
        $this->addAttachment($attachment);
        $this->getAttachments()->shouldHaveCount(1);
    }

    function it_adds_attachments_to_serialized_output(AttachmentCollection $attachments, AttachmentInterface $attachment)
    {
        $attachments->add($attachment)->shouldBeCalled();
        $attachments->count()->willReturn(1);
        $attachments->jsonSerialize()->shouldBeCalled();

        $this->setAttachments($attachments);
        $this->addAttachment($attachment);
        $this->jsonSerialize();
    }

    function it_does_not_add_attachments_if_empty(AttachmentCollection $attachments)
    {
        $attachments->count()->shouldBeCalled();
        $attachments->jsonSerialize()->shouldNotBeCalled();

        $this->setAttachments($attachments)->jsonSerialize();
    }
}
