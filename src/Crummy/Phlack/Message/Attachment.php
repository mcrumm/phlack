<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Message\Collection\FieldCollection;

class Attachment extends Partial implements AttachmentInterface
{
    /**
     * @var Collection\FieldCollection
     */
    private $fields;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->fields = new FieldCollection();
    }

    /**
     * @param $fallback
     * @return $this
     */
    public function setFallback($fallback)
    {
        return $this->set('fallback', $fallback);
    }

    /**
     * @param $text
     * @return $this
     */
    public function setText($text)
    {
        return $this->set('text', $text);
    }

    /**
     * @param $pretext
     * @return $this
     */
    public function setPretext($pretext)
    {
        return $this->set('pretext', $pretext);
    }

    /**
     * @param $color
     * @return $this
     */
    public function setColor($color)
    {
        return $this->set('color', $color);
    }

    /**
     * @param FieldInterface $field
     * @return $this;
     */
    public function addField(FieldInterface $field)
    {
        $this->fields->add($field);
        return $this;
    }

    /**
     * @param FieldCollection $fields
     * @return $this
     */
    public function setFields(FieldCollection $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return FieldCollection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return parent::jsonSerialize() + [ 'fields' => $this->fields->jsonSerialize() ];
    }
}
