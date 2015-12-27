<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\OptionsResolver;
use Crummy\Phlack\Message\Collection\FieldCollection;

class Attachment extends Partial implements AttachmentInterface
{
    protected $required = ['fallback'];
    protected $optional = ['text', 'pretext', 'color', 'fields', 'author_name', 'author_link', 'author_icon', 'title', 'title_link', 'image_url', 'thumb_url', 'mrkdwn_in'];

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
     * @param $fallback
     *
     * @return $this
     *
     * @deprecated Will be removed in 0.6.0
     */
    public function setFallback($fallback)
    {
        $this['fallback'] = (string) $fallback;

        return $this;
    }

    /**
     * @param $text
     *
     * @return $this
     *
     * @deprecated Will be removed in 0.6.0
     */
    public function setText($text)
    {
        $this['text'] = (string) $text;

        return $this;
    }

    /**
     * @param $pretext
     *
     * @return $this
     *
     * @deprecated Will be removed in 0.6.0
     */
    public function setPretext($pretext)
    {
        $this['pretext'] = (string) $pretext;

        return $this;
    }

    /**
     * @param $color
     *
     * @return $this
     *
     * @deprecated Will be removed in 0.6.0
     */
    public function setColor($color)
    {
        $this['color'] = (string) $color;

        return $this;
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
     * @param FieldCollection $fields
     *
     * @return $this
     *
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

    /**
     * @param $author_name
     *
     * @return $this
     */
    public function setAuthorName($author_name)
    {
        $this['author_name'] = (string) $author_name;

        return $this;
    }

    /**
     * @param $author_link
     *
     * @return $this
     */
    public function setAuthorLink($author_link)
    {
        $this['author_link'] = (string) $author_link;

        return $this;
    }

    /**
     * @param $author_icon
     *
     * @return $this
     */
    public function setAuthorIcon($author_icon)
    {
        $this['author_icon'] = (string) $author_icon;

        return $this;
    }

    /**
     * @param $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this['title'] = (string) $title;

        return $this;
    }

    /**
     * @param $title_link
     *
     * @return $this
     */
    public function setTitleLink($title_link)
    {
        $this['title_link'] = (string) $title_link;

        return $this;
    }

    /**
     * @param $image_url
     *
     * @return $this
     */
    public function setImageUrl($image_url)
    {
        $this['image_url'] = (string) $image_url;

        return $this;
    }

    /**
     * @param $thumb_url
     *
     * @return $this
     */
    public function setThumbUrl($thumb_url)
    {
        $this['thumb_url'] = (string) $thumb_url;

        return $this;
    }

    /**
     * @param $mrkdwn_in
     *
     * @return $this
     */
    public function setMrkdwnIn($mrkdwn_in)
    {
        $this['mrkdwn_in'] = $mrkdwn_in;

        return $this;
    }
}
