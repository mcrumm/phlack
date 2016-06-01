<?php

namespace Crummy\Phlack\Bot;

use Crummy\Phlack\WebHook\CommandInterface;

class RepeaterBot extends AbstractBot
{
    /**
     * @param CommandInterface $command
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function execute(CommandInterface $command)
    {
        $text = preg_replace(sprintf('/^%s /', $command['command']), '', $command['text']);

        return $this->reply($command, $text);
    }
}
