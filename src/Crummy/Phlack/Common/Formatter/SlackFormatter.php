<?php

namespace Crummy\Phlack\Common\Formatter;

use Crummy\Phlack\WebHook\CommandInterface;

class SlackFormatter extends AbstractFormatter
{
    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        $message = $this->message->jsonSerialize();
        $message['text'] = htmlspecialchars($message['text'], ENT_NOQUOTES);
        return $message;
    }

    /**
     * @return string
     */
    public function formatUserString()
    {
        if (!$this->message instanceof CommandInterface) {
            return '';
        }

        return $this->format('@'.$this->message['user_id'], $this->message['user_name']);
    }

    /**
     * @return string
     */
    public function formatChannelString()
    {
        if (!$this->message instanceof CommandInterface) {
            return '';
        }

        return $this->format('#'.$this->message['channel_id'], $this->message['channel_name']);
    }
}
