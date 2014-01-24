<?php

namespace Crummy\Phlack\Builder;

use Crummy\Phlack\Message\Attachment;
use Crummy\Phlack\Message\Collection\FieldCollection;
use Crummy\Phlack\Message\Field;

class AttachmentBuilder implements BuilderInterface
{
    private $data;
    private $fields;

    public function __construct()
    {
        $this->refresh();
    }

    /**
     * @return Attachment
     * @throws \LogicException When called before setFallback($fallback)
     */
    public function create()
    {
        if (null === ($this->data['fallback'])) {
            throw new \LogicException('Fallback must be set before creating the Attachment');
        }

        $data   = $this->data;
        $fields = $this->fields;

        $this->refresh();

        return $this->build($data, $fields);
    }

    /**
     * @param $fallback
     * @return $this
     */
    public function setFallback($fallback)
    {
        return $this->setParameter('fallback', $fallback);
    }

    /**
     * @param $text
     * @return $this
     */
    public function setText($text)
    {
        return $this->setParameter('text', $text);
    }

    /**
     * @param $pretext
     * @return $this
     */
    public function setPretext($pretext)
    {
        return $this->setParameter('pretext', $pretext);
    }

    /**
     * @param $color
     * @return $this
     */
    public function setColor($color)
    {
        return $this->setParameter('color', $color);
    }

    /**
     * Sets values on non-empty parameters.
     * Set $value to null to remove the custom value.
     * @param $name
     * @param $value
     * @return $this
     */
    private function setParameter($name, $value)
    {
        if (null !== $value && empty($value)) { return $this; }

        $this->data[$name] = $value;

        return $this;
    }

    /**
     * @param string $title
     * @param string $value
     * @param boolean $isShort
     * @return $this
     */
    public function addField($title, $value, $isShort)
    {
        $this->fields->add(new Field($title, $value, $isShort));

        return $this;
    }

    /**
     * Reset the attachment data and the fields collection.
     */
    protected function refresh()
    {
        $this->data = [
            'fallback' => null,
            'text'     => null,
            'pretext'  => null,
            'color'    => null
        ];

        $this->fields = new FieldCollection();
    }

    /**
     * @param array $data
     * @param FieldCollection $fields
     * @return Attachment
     */
    protected function build(array $data, FieldCollection $fields)
    {
        $attachment = new Attachment();

        foreach (array_keys($data) as $key) {
            $method = 'set'.ucfirst($key);
            $attachment->{$method}($data[$key]);
        }

        $attachment->setFields($fields);

        return $attachment;
    }
}
