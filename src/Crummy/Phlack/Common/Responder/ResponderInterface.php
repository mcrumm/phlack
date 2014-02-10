<?php

namespace Crummy\Phlack\Common\Responder;

use Crummy\Phlack\Message\MessageInterface;

interface ResponderInterface
{
    /**
     * @param string $text
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    function say($text);

    /**
     * @param string $text
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    function emote($text);

    /**
     * @param string $user
     * @param string $text
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    function tell($user, $text);

    /**
     * @param MessageInterface $message
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    function send(MessageInterface $message);
}
