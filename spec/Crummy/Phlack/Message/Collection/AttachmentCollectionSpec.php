<?php

namespace spec\Crummy\Phlack\Message\Collection;

use Crummy\Phlack\Message\AttachmentInterface;
use Crummy\Phlack\Message\FieldInterface;
use PhpSpec\ObjectBehavior;

class AttachmentCollectionSpec extends ObjectBehavior
{
    function let(AttachmentInterface $attachment)
    {
        $this->beConstructedWith([$attachment]);
    }

    function it_is_an_encodable_collection()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Collection\AttachmentCollection');
        $this->shouldImplement('\Crummy\Phlack\Message\Collection\EncodableCollection');
    }

    function it_accepts_attachment_interface_elements(AttachmentInterface $attachment)
    {
        $this->acceptsType($attachment)->shouldReturn(true);
    }

    function it_does_not_allow_other_elements_during_add(FieldInterface $field)
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Common\Exception\RuntimeException')
            ->during('add', [$field]);
    }

    function it_does_not_allow_other_elements_during_set(FieldInterface $field)
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Common\Exception\RuntimeException')
            ->during('set', ['the_key', $field]);
    }

    function it_adds_attachments_to_the_collection(AttachmentInterface $attachment)
    {
        $this->add($attachment)->shouldReturn(true);
        $this->contains($attachment)->shouldReturn(true);
    }

    function it_sets_attachments_to_the_collection(AttachmentInterface $attachment)
    {
        $this->set('attachment1', $attachment)->shouldReturn(null);
        $this->get('attachment1')->shouldReturn($attachment);
    }
}
