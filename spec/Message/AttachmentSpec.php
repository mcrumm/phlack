<?php

namespace spec\Crummy\Phlack\Message;

use Crummy\Phlack\Message\FieldInterface;
use PhpSpec\ObjectBehavior;

class AttachmentSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['fallback' => get_class()]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Attachment');
    }

    function it_is_encodable()
    {
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    function it_contains_a_field_collection()
    {
        $this['fields']->shouldReturnAnInstanceOf('\Crummy\Phlack\Message\Collection\FieldCollection');
    }

    function it_fluently_adds_field_interfaces(FieldInterface $field)
    {
        $this->addField($field)->shouldReturn($this);
    }

    function it_has_no_fields_by_default()
    {
        $this->offsetGet('fields')->shouldHaveCount(0);
    }

    function it_increments_the_field_count_on_add(FieldInterface $field)
    {
        $this->addField($field);
        $this->offsetGet('fields')->shouldHaveCount(1);
    }

    function it_adds_fields_to_serialized_output(FieldInterface $field)
    {
        $this->addField($field);
        $this->jsonSerialize()['fields']->shouldHaveCount(1);
    }

    function it_returns_its_fields_as_a_collection()
    {
        $this->getFields()->shouldBeAnInstanceOf('Crummy\Phlack\Message\Collection\FieldCollection');
    }

    function it_returns_a_collection_containing_the_added_field(FieldInterface $field)
    {
        $this->addField($field);
        $this->getFields()->toArray()->shouldContain($field);
    }
}
