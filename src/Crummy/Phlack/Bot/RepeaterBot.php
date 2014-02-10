<?php

namespace Crummy\Phlack\Bot;

use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\WebHook;

class RepeaterBot extends AbstractBot
{
    /**
     * @param CommandInterface $command
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function execute(CommandInterface $command)
    {
        if ($command instanceof WebHook) {
            $text = str_replace($command->getCommand(), '', $command->getText());
        } else {
            $text = $command->getCommand();
        }

        return $this->say($text);
    }
}
