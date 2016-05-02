<?php

namespace spec\Crummy\Phlack\Builder;

use Crummy\Phlack\Message\AttachmentInterface;
use Crummy\Phlack\Message\Message;
use PhpSpec\ObjectBehavior;

class MessageBuilderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Builder\MessageBuilder');
    }

    public function it_is_a_builder()
    {
        $this->shouldImplement('\Crummy\Phlack\Builder\BuilderInterface');
    }

    public function it_returns_a_message_on_create()
    {
        $this->setText('Message')->create()->shouldReturnAnInstanceOf('\Crummy\Phlack\Message\Message');
    }

    public function it_fluently_sets_vars()
    {
        $this->setText('text')->shouldReturn($this);
        $this->setChannel('channel')->shouldReturn($this);
        $this->setIconEmoji('package')->shouldReturn($this);
        $this->setUsername('user')->shouldReturn($this);
    }

    public function it_refreshes_data_on_create()
    {
        $message_1 = $this->setText('Message #1')->setChannel('1')->create();

        /** @var Message $message_2 */
        $message_2 = $this->setText('Message #2')->create();
        $message_2['channel']->shouldBeNull();
    }

    public function it_adds_attachments(AttachmentInterface $attachment)
    {
        $this->addAttachment($attachment)->shouldReturn($this);
    }

    public function it_fluently_creates_attachments()
    {
        $this
            ->setText('Text')
            ->createAttachment()
                ->setFallback('The fallback')
            ->end()
            ->create()['attachments']->shouldHaveCount(1);
    }
}
