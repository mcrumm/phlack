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
     * @throws \LogicException When called before setFallback($fallback)
     *
     * @return Attachment
     */
    public function create()
    {
        $attachment = new Attachment($this->data + ['fields' => clone $this->fields]);
        $this->refresh();

        return $attachment;
    }

    /**
     * @param $fallback
     *
     * @return $this
     */
    public function setFallback($fallback)
    {
        return $this->setParameter('fallback', (string) $fallback);
    }

    /**
     * @param $text
     *
     * @return $this
     */
    public function setText($text)
    {
        return $this->setParameter('text', $text);
    }

    /**
     * @param $pretext
     *
     * @return $this
     */
    public function setPretext($pretext)
    {
        return $this->setParameter('pretext', $pretext);
    }

    /**
     * @param $color
     *
     * @return $this
     */
    public function setColor($color)
    {
        return $this->setParameter('color', $color);
    }

    /**
     * @param $author_name
     *
     * @return $this
     */
    public function setAuthorName($author_name)
    {
        return $this->setParameter('author_name', $author_name);
    }

    /**
     * @param $author_link
     *
     * @return $this
     */
    public function setAuthorLink($author_link)
    {
        return $this->setParameter('author_link', $author_link);
    }

    /**
     * @param $author_icon
     *
     * @return $this
     */
    public function setAuthorIcon($author_icon)
    {
        return $this->setParameter('author_icon', $author_icon);
    }

    /**
     * @param $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setParameter('title', $title);
    }

    /**
     * @param $title_link
     *
     * @return $this
     */
    public function setTitleLink($title_link)
    {
        return $this->setParameter('title_link', $title_link);
    }

    /**
     * @param $image_url
     *
     * @return $this
     */
    public function setImageUrl($image_url)
    {
        return $this->setParameter('image_url', $image_url);
    }

    /**
     * @param $thumb_url
     *
     * @return $this
     */
    public function setThumbUrl($thumb_url)
    {
        return $this->setParameter('thumb_url', $thumb_url);
    }

    /**
     * @param $mrkdwn_in
     *
     * @return $this
     */
    public function setMrkdwnIn($mrkdwn_in)
    {
        return $this->setParameter('mrkdwn_in', $mrkdwn_in);
    }

    /**
     * Sets values on non-empty parameters.
     * Set $value to null to remove the custom value.
     *
     * @param string $name
     * @param $value
     *
     * @return $this
     */
    private function setParameter($name, $value)
    {
        if (null !== $value && empty($value)) {
            return $this;
        }

        $this->data[$name] = $value;

        return $this;
    }

    /**
     * @param string $title
     * @param string $value
     * @param bool   $isShort
     *
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
