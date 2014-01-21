<?php

namespace spec\Crummy\Phlack\Builder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttachmentBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Builder\AttachmentBuilder');
    }

    function it_is_a_builder()
    {
        $this->shouldImplement('\Crummy\Phlack\Builder\BuilderInterface');
    }

    function it_provides_a_fluent_interface()
    {
        $this->setFallback('fallback')->shouldReturn($this);
        $this->setText('text')->shouldReturn($this);
        $this->setPretext('pretext')->shouldReturn($this);
        $this->setColor('danger')->shouldReturn($this);
    }

    function it_fails_on_empty_fallback()
    {
        $this->shouldThrow('\LogicException')->during('create');
    }

    function it_creates_an_attachment()
    {
        $this
            ->setFallback('fallback')
            ->create()
                ->shouldReturnAnInstanceOf('\Crummy\Phlack\Message\Attachment');
    }

    function it_fluently_accepts_field_data()
    {
        $this
            ->addField('title', 'value', true)
            ->shouldReturn($this);
    }

    function it_adds_fields_to_the_attachment()
    {
        $attachment = $this->setFallback('fallback')->addField('title', 'value', true)->create();
        $attachment->getFields()->shouldHaveCount(1);
    }
}
