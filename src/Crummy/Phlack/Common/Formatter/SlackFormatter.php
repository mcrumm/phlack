<?php

namespace Crummy\Phlack\Common\Formatter;

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
}
