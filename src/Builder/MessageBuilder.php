<?php

namespace Crummy\Phlack\Builder;

use Crummy\Phlack\Message\AttachmentInterface;
use Crummy\Phlack\Message\Collection\AttachmentCollection;
use Crummy\Phlack\Message\Message;

class MessageBuilder implements BuilderInterface
{
    private $data = [];
    private $attachments;
    private $attachmentBuilder;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->attachments = new AttachmentCollection();
    }

    /**
     * @throws \LogicException When create is called before text has been set
     */
    public function create()
    {
        $message = new Message(
            isset($this->data['text']) ? $this->data['text'] : null,
            isset($this->data['channel']) ? $this->data['channel'] : null,
            isset($this->data['username']) ? $this->data['username'] : null,
            isset($this->data['icon_emoji']) ? $this->data['icon_emoji'] : null
        );

        $message['attachments'] = clone $this->attachments;

        $this->refresh();

        return $message;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->data['text'] = $text;

        return $this;
    }

    /**
     * @param $channel
     *
     * @return $this
     */
    public function setChannel($channel)
    {
        $this->data['channel'] = $channel;

        return $this;
    }

    /**
     * @param $iconEmoji
     *
     * @return $this
     */
    public function setIconEmoji($iconEmoji)
    {
        $this->data['icon_emoji'] = $iconEmoji;

        return $this;
    }

    /**
     * @param $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->data['username'] = $username;

        return $this;
    }

    /**
     * Reset data to an empty message.
     */
    protected function refresh()
    {
        $this->data = [];
        $this->attachments->clear();
    }

    /**
     * @param AttachmentInterface $attachment
     *
     * @return $this
     */
    public function addAttachment(AttachmentInterface $attachment)
    {
        $this->attachments->add($attachment);

        return $this;
    }

    /**
     * @return AttachmentBuilder
     */
    public function createAttachment()
    {
        if (!$this->attachmentBuilder) {
            $this->attachmentBuilder = new AttachmentBuilder($this);
        }

        return $this->attachmentBuilder;
    }
}
