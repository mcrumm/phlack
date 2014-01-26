<?php

namespace spec\Crummy\Phlack\Message\Collection;

use Crummy\Phlack\Message\Attachment;
use Crummy\Phlack\Message\Field;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FieldCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Collection\FieldCollection');
    }

    function it_is_encodable()
    {
        $this->shouldImplement('\Crummy\Phlack\Message\Collection\EncodableCollection');
    }

    function it_accepts_field_interface_elements(Field $field)
    {
        $this->acceptsElement($field)->shouldReturn(true);
    }

    function it_does_not_allow_other_elements(Attachment $attachment)
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Common\Exception\ElementNotAcceptedException')
            ->during('add', array($attachment));
    }
}
