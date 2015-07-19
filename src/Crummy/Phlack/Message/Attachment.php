<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\OptionsResolver;
use Crummy\Phlack\Message\Collection\FieldCollection;

class Attachment extends Partial implements AttachmentInterface
{
    protected $required = [ 'fallback' ];
    protected $optional = [ 'text', 'pretext', 'color', 'fields' ];

    /**
     * {@inheritDoc}
     */
    public function __construct($data = [])
    {
        if (!isset($data['fields'])) {
            $data['fields'] = new FieldCollection();
        }

        parent::__construct($data);
    }

    /**
     * {@inheritDoc}
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setTypesAllowed([
            'fields' => '\Crummy\Phlack\Message\Collection\FieldCollection'
        ]);
    }

    /**
     * @param $fallback
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setFallback($fallback)
    {
        $this['fallback'] = (string)$fallback;
        return $this;
    }

    /**
     * @param $text
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setText($text)
    {
        $this['text'] = (string)$text;
        return $this;
    }

    /**
     * @param $pretext
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setPretext($pretext)
    {
        $this['pretext'] = (string)$pretext;
        return $this;
    }

    /**
     * @param $color
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setColor($color)
    {
        $this['color'] = (string)$color;
        return $this;
    }

    /**
     * @param FieldInterface $field
     * @return $this
     */
    public function addField(FieldInterface $field)
    {
        $this['fields']->add($field);
        return $this;
    }

    /**
     * @param FieldCollection $fields
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setFields(FieldCollection $fields)
    {
        $this['fields'] = $fields;
        return $this;
    }

    /**
     * @return FieldCollection
     */
    public function getFields()
    {
        return $this['fields'];
    }
}
