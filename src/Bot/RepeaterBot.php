<?php

namespace Crummy\Phlack\Bot;

use Crummy\Phlack\Message\Message;
use Crummy\Phlack\WebHook\Command;

class RepeaterBot extends AbstractBot
{
    /**
     * @param Command $command
     *
     * @return Message
     */
    public function execute(Command $command)
    {
        $text = preg_replace(sprintf('/^%s /', $command['command']), '', $command['text']);

        return $this->reply($command, $text);
    }
}
