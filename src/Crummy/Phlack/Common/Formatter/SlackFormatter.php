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
        if (isset($message['text'])) {
            $message['text'] = $this->slackEncode($message['text']);
        }
        return $message;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->slackEncode((string)$this->message);
    }

    /**
     * @return string
     */
    public function formatText()
    {
        if (isset($this->message['text'])) {
            return $this->slackEncode($this->message['text']);
        }

        return '';
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

    /**
     * @param $text
     * @return string
     */
    private function slackEncode($text)
    {
        $text = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8', false);
        return preg_replace('/\[((?|((?|(@U)|(#C))[0-9]+\|?\w*))|(!\w+))\]/', '<\1>', $text);
    }
}
