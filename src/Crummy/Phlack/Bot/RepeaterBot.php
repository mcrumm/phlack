<?php

namespace Crummy\Phlack\Bot;

use Crummy\Phlack\WebHook\CommandInterface;

class RepeaterBot extends AbstractBot
{
    /**
     * @param CommandInterface $command
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function execute(CommandInterface $command)
    {
        return $this->say($command->getText());
    }
}
