<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\OptionsResolver;
use Crummy\Phlack\Message\Collection\FieldCollection;

class Attachment extends Partial implements AttachmentInterface
{
    protected $optional = [
        'fallback',
        'text',
        'pretext',
        'color',
        'fields',
        'author_name',
        'author_link',
        'author_icon',
        'title',
        'title_link',
        'image_url',
        'thumb_url',
        'mrkdwn_in',
    ];

    /**
     * {@inheritdoc}
     */
    public function __construct($data = [])
    {
        if (!isset($data['fields'])) {
            $data['fields'] = new FieldCollection();
        }

        parent::__construct($data);
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setTypesAllowed([
            'fields' => '\Crummy\Phlack\Message\Collection\FieldCollection',
        ]);
    }

    /**
     * @param FieldInterface $field
     *
     * @return $this
     */
    public function addField(FieldInterface $field)
    {
        $this['fields']->add($field);

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
