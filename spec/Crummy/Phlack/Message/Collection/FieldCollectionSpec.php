<?php

namespace spec\Crummy\Phlack\Message\Collection;

use Crummy\Phlack\Message\Attachment;
use Crummy\Phlack\Message\Field;
use PhpSpec\ObjectBehavior;

class FieldCollectionSpec extends ObjectBehavior
{
    public function it_is_an_encodable_collection()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Collection\FieldCollection');
        $this->shouldImplement('\Crummy\Phlack\Message\Collection\EncodableCollection');
    }

    public function it_accepts_field_interface_elements(Field $field)
    {
        $this->acceptsType($field)->shouldReturn(true);
    }

    public function it_does_not_allow_other_elements(Attachment $attachment)
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Common\Exception\RuntimeException')
            ->during('add', [$attachment]);
    }
}
