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
        $this->getText()->shouldReturn(self::TEXT);
    }

    public function it_fluently_accepts_an_optional_channel()
    {
        $this->setChannel(self::CHANNEL)->shouldReturn($this);
    }

    public function it_allows_for_direct_messages_in_channel()
    {
        $this->setChannel('@mcrumm')->getChannel()->shouldReturn('@mcrumm');
    }

    public function it_does_not_alter_passed_channel()
    {
        $this->setChannel(':channel_id')->getChannel()->shouldReturn(':channel_id');
    }

    public function it_fluently_accepts_an_icon_emoji()
    {
        $this->setIconEmoji(self::ICON_EMOJI)->shouldReturn($this);
    }

    public function it_wraps_icon_emoji_in_colons()
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

    public function it_fluently_accepts_an_username()
    {
        $this->setUsername(self::USERNAME)->shouldReturn($this);
        $this->getUsername()->shouldReturn(self::USERNAME);
    }

    public function it_prints_as_json()
    {
        $this
            ->setChannel(self::CHANNEL)
            ->__toString()
            ->shouldReturn(json_encode([
                'text'        => self::TEXT,
                'channel'     => self::CHANNEL,
            ]));
    }

    public function it_sets_an_AttachmentCollection_on_the_Message(AttachmentCollection $attachments, AttachmentInterface $attachment)
    {
        $this->setAttachments($attachments)->shouldReturn($this);
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

        $this->setAttachments($attachments)->jsonSerialize();
    }
}
