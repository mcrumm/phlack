<?php

namespace Crummy\Phlack\Common\Responder;

use Crummy\Phlack\Message\MessageInterface;

interface ResponderInterface
{
    /**
     * @param string $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function say($text);

    /**
     * @param string $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function emote($text);

    /**
     * @param string $user
     * @param string $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function tell($user, $text);

    /**
     * @param string $user
     * @param string $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function reply($user, $text);

    /**
     * @param string $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function shout($text);

    /**
     * @param MessageInterface $message
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function send(MessageInterface $message);
}
