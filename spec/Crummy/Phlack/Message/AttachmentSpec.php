<?php

namespace spec\Crummy\Phlack\Message;

use Crummy\Phlack\Message\Collection\FieldCollection;
use Crummy\Phlack\Message\FieldInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttachmentSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([ 'fallback' => get_class() ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Attachment');
    }

    function it_is_encodable()
    {
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    function it_provides_a_fluent_interface()
    {
        $this->setFallback('fallback')->shouldReturn($this);
        $this->setText('text')->shouldReturn($this);
        $this->setPretext('pretext')->shouldReturn($this);
        $this->setColor('danger')->shouldReturn($this);
    }

    function it_contains_a_field_collection()
    {
        $this['fields']->shouldReturnAnInstanceOf('\Crummy\Phlack\Message\Collection\FieldCollection');
    }

    function it_fluently_adds_field_interfaces(FieldInterface $field)
    {
        $this->addField($field)->shouldReturn($this);
    }

    function it_adds_fields_to_the_collection(FieldCollection $fields, FieldInterface $field)
    {
        $fields->add($field)->shouldBeCalled();

        $this->setFields($fields);
        $this->addField($field);
    }

    function it_increments_the_field_count_on_add(FieldInterface $field)
    {
        $this->addField($field);
        $this->getFields()->shouldHaveCount(1);
    }

    function it_adds_fields_to_serialized_output(FieldInterface $field)
    {
        $this->addField($field);
        $this->jsonSerialize()['fields']->shouldHaveCount(1);
    }
}
