<?php

namespace spec\Crummy\Phlack\Builder;

use Crummy\Phlack\Builder\MessageBuilder;
use PhpSpec\ObjectBehavior;

class AttachmentBuilderSpec extends ObjectBehavior
{
    public function let(MessageBuilder $messageBuilder)
    {
        $this->beConstructedWith($messageBuilder);
    }

    public function it_is_a_BuilderInterface()
    {
        $this->shouldHaveType('Crummy\Phlack\Builder\AttachmentBuilder');
        $this->shouldImplement('\Crummy\Phlack\Builder\BuilderInterface');
    }

    public function it_provides_a_fluent_interface()
    {
        $this->setFallback('fallback')->shouldReturn($this);
        $this->setText('text')->shouldReturn($this);
        $this->setPretext('pretext')->shouldReturn($this);
        $this->setColor('danger')->shouldReturn($this);
        $this->setAuthorName('author name')->shouldReturn($this);
        $this->setAuthorLink('author link')->shouldReturn($this);
        $this->setAuthorIcon('http://domain.com/icon.png')->shouldReturn($this);
        $this->setTitle('title')->shouldReturn($this);
        $this->setTitleLink('http://www.title-link.com/')->shouldReturn($this);
        $this->setImageUrl('http://domain.com/image.png')->shouldReturn($this);
        $this->setThumbUrl('http://domain.com/thumb.png')->shouldReturn($this);
        $this->setMrkdwnIn(['text', 'pretext'])->shouldReturn($this);
    }

    public function it_creates_an_attachment()
    {
        $this
            ->setFallback('fallback')
            ->create()
                ->shouldReturnAnInstanceOf('\Crummy\Phlack\Message\Attachment');
    }

    public function it_fluently_accepts_field_data()
    {
        $this
            ->addField('title', 'value', true)
            ->shouldReturn($this);
    }

    public function it_adds_fields_to_the_attachment()
    {
        $attachment = $this->setFallback('fallback')->addField('title', 'value', true)->create();
        $attachment['fields']->shouldHaveCount(1);
    }

    public function it_refreshes_data_on_create()
    {
        $attachment_1 = $this->setFallback('attachment 1')->addField('attach', '1', true)->create();

        /** @var \Crummy\Phlack\Message\Attachment $attachment_2 */
        $attachment_2 = $this->setFallback('attachment 2')
            ->addField('so_attach', '2', true)
            ->addField('much_fields', '3', true)
            ->create();

        $attachment_1['fields']->shouldHaveCount(1);
        $attachment_2['fields']->shouldHaveCount(2);
    }

    public function it_returns_its_parent_on_end(MessageBuilder $messageBuilder)
    {
        $this->setFallback('foo');
        $this->end()->shouldReturn($messageBuilder);
    }

    public function it_returns_self_on_end_when_no_parent_is_set()
    {
        $this->beConstructedWith();
        $this->end()->shouldReturn($this);
    }

    public function it_does_not_set_an_empty_value()
    {
        $attachment = $this->setFallback('fallback')->setFallback('')->create();

        $attachment['fallback']->shouldBe('fallback');
    }
}
