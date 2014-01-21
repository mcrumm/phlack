<?php

namespace spec\Crummy\Phlack\Message\Collection;

use Crummy\Phlack\Message\AttachmentInterface;
use Crummy\Phlack\Message\Collection\FieldCollection;
use Crummy\Phlack\Message\FieldInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttachmentCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Collection\AttachmentCollection');
    }

    function it_is_encodable()
    {
        $this->shouldImplement('\Crummy\Phlack\Message\Collection\EncodableCollection');
    }

    function it_accepts_attachment_interface_elements(AttachmentInterface $attachment)
    {
        $this->acceptsElement($attachment)->shouldReturn(true);
    }

    function it_does_not_allow_other_elements(FieldInterface $field)
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Exception\ElementNotAcceptedException')
            ->during('add', array($field));
    }
}
