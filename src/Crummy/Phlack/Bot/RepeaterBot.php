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
        $name   = $command->get('command');
        $user   = $command->get('user_name');
        $text   = $command->get('text');

        // Remove command from text if matching (E.g text "go: back" would become "back")
        if (0 === strcasecmp($name, substr($text, 0, strlen($name)))) {
            $text = str_replace($name.' ', '', $text);
        }

        return $this->reply($user, $text);
    }
}
