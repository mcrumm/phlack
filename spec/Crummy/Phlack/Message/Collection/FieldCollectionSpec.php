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

    /**
     *  @dataProvider fieldExamples
     */
    public function it_can_be_passed_to_json_encode($field, $expected)
    {
        $this->add($field);

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    /**
     *  @dataProvider jsonExamples
     */
    public function it_can_be_cast_as_a_json_string($field, $expected)
    {
        $this->add($field);

        $this->__toString()->shouldBe($expected);
    }

    public function fieldExamples()
    {
        return $this->getExamples(function ($example) {
            $field = Field::fromConfig($example);

            return [$field, [$field]];
        });
    }

    public function jsonExamples()
    {
        return $this->getExamples(function ($example) {
            $field = Field::fromConfig($example);

            return [$field, json_encode([$field])];
        });
    }

    public function getExamples(callable $callback)
    {
        $data = [
            [
                'title' => 'Field 1',
                'value' => 1,
                'short' => true,
            ],
            [
                'title' => 'Field 2',
                'value' => 2,
                'short' => false,
            ],
        ];

        return array_map($callback, $data);
    }
}
