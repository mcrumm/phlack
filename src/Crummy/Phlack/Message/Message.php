<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\OptionsResolver;
use Crummy\Phlack\Message\Collection\AttachmentCollection;
use Symfony\Component\OptionsResolver\Options;

class Message extends Partial implements MessageInterface
{
    protected $required = [ 'text' ];
    protected $optional = [ 'channel', 'username', 'icon_emoji', 'attachments' ];

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
     * {@inheritDoc}
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setTypesAllowed([
            'attachments' => '\Crummy\Phlack\Message\Collection\AttachmentCollection'
        ]);

        $resolver->setNormalizers([
            'channel' => function (Options $options, $value) {
                return empty($value) ? $value : (0 === strpos($value, '#') ? $value : (0 === strpos($value, '@') ? $value : '#' . $value));
            },
            'icon_emoji' => function(Options $options, $value) {
                return empty($value) ? $value : sprintf(':%s:', trim($value, ':'));
            }
        ]);
    }

    /**
     * @return string
     * @deprecated Will be removed in 0.6.0
     */
    public function getText()
    {
        return $this->data['text'];
    }

    /**
     * @param $channel
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setChannel($channel)
    {
        if (!empty($channel)) {
            $this->data['channel'] = (0 === strpos($channel, '#') ? $channel : (0 === strpos($channel, '@') ? $channel : '#' . $channel));
        }
        return $this;
    }

    /**
     * @return string|null
     * @deprecated Will be removed in 0.6.0
     */
    public function getChannel()
    {
        return isset($this->data['channel']) ? $this->data['channel'] : null;
    }

    /**
     * @param $iconEmoji
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setIconEmoji($iconEmoji)
    {
        if (!empty($iconEmoji)) {
            $this->data['icon_emoji'] = sprintf(':%s:', trim($iconEmoji, ':'));
        }
        return $this;
    }

    /**
     * @return string|null
     * @deprecated Will be removed in 0.6.0
     */
    public function getIconEmoji()
    {
        return isset($this->data['icon_emoji']) ? $this->data['icon_emoji'] : null;
    }

    /**
     * @param $username
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setUsername($username)
    {
        if (!empty($username)) {
            $this->data['username'] = $username;
        }
        return $this;
    }

    /**
     * @return string|null
     * @deprecated Will be removed in 0.6.0
     */
    public function getUsername()
    {
        return isset($this->data['username']) ? $this->data['username'] : null;
    }

    /**
     * @param AttachmentCollection $attachments
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setAttachments(AttachmentCollection $attachments)
    {
        return $this->set('attachments', $attachments);
    }

    /**
     * @param AttachmentInterface $attachment
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
