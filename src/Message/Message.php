<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\OptionsResolver;
use Crummy\Phlack\Message\Collection\AttachmentCollection;
use Symfony\Component\OptionsResolver\Options;

class Message extends Partial implements MessageInterface
{
    protected $optional = ['text', 'channel', 'username', 'icon_emoji', 'attachments'];

    /**
     * @param $text
     * @param null $channel
     * @param null $username
     * @param null $iconEmoji
     */
    public function __construct($text, $channel = null, $username = null, $iconEmoji = null)
    {
        parent::__construct([
            'text'          => $text,
            'channel'       => $channel,
            'username'      => $username,
            'icon_emoji'    => $iconEmoji,
            'attachments'   => new AttachmentCollection(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setTypesAllowed([
            'attachments' => '\Crummy\Phlack\Message\Collection\AttachmentCollection',
        ]);

        $resolver->setNormalizers([
            'icon_emoji' => function (Options $options, $value) {
                return empty($value) ? $value : sprintf(':%s:', trim($value, ':'));
            },
        ]);
    }

    /**
     * @param AttachmentInterface $attachment
     *
     * @return $this
     */
    public function addAttachment(AttachmentInterface $attachment)
    {
        $this['attachments']->add($attachment);

        return $this;
    }

    /**
     * @return AttachmentCollection
     */
    public function getAttachments()
    {
        return $this->data['attachments'];
    }
}
