<?php

namespace Crummy\Phlack\Builder;

use Crummy\Phlack\Message\Attachment;
use Crummy\Phlack\Message\Collection\FieldCollection;
use Crummy\Phlack\Message\Field;

class AttachmentBuilder implements BuilderInterface
{
    private $data = [];
    private $fields;
    private $parent;

    /**
     * Constructor.
     */
    public function __construct(MessageBuilder $parent = null)
    {
        $this->parent = $parent;
        $this->fields = new FieldCollection();
    }

    /**
     * @return Attachment
     * @throws \LogicException When called before setFallback($fallback)
     */
    public function create()
    {
        $attachment = new Attachment( $this->data + [ 'fields' => clone $this->fields ]);
        $this->refresh();
        return $attachment;
    }

    /**
     * @param $fallback
     * @return $this
     */
    public function setFallback($fallback)
    {
        $this->data['fallback'] = (string)$fallback;
        return $this;
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
        $this->data = [];
        $this->fields->clear();
    }

    /**
     * @return MessageBuilder
     */
    public function end()
    {
        if ($this->parent) {
            $this->parent->addAttachment($this->create());
            return $this->parent;
        }
        return $this;
    }
}
