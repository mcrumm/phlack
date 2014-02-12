<?php

namespace Crummy\Phlack\Bot;

use Crummy\Phlack\Common\Iterocitor;
use Crummy\Phlack\Common\Matcher;
use Crummy\Phlack\Common\Responder\ResponderInterface;
use Crummy\Phlack\Message\MessageInterface;

abstract class AbstractBot implements BotInterface, Matcher\MatcherAggregate
{
    private $matcher;
    private $responder;

    /**
     * @param Matcher\MatcherInterface $matcher
     * @param array|ResponderInterface $options
     */
    public function __construct(Matcher\MatcherInterface $matcher = null, $options = [ ])
    {
        $this->matcher   = $matcher ?: new Matcher\DefaultMatcher();
        $this->responder = $options instanceof ResponderInterface ? $options : new Iterocitor($options);
    }

    /**
     * @param Matcher\MatcherInterface $matcher
     * @return $this
     */
    public function setMatcher(Matcher\MatcherInterface $matcher)
    {
        $this->matcher = $matcher;
        return $this;
    }

    /**
     * @return Matcher\MatcherInterface
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * @param string $text
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    protected function say($text)
    {
        return $this->responder->say($text);
    }

    /**
     * @param string $text
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    protected function emote($text)
    {
        return $this->responder->emote($text);
    }

    /**
     * @param string $user
     * @param string $text
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    protected function tell($user, $text)
    {
        return $this->responder->tell($user, $text);
    }

    /**
     * @param string $user
     * @param string $text
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    protected function reply($user, $text)
    {
        return $this->responder->reply($user, $text);
    }

    /**
     * @param MessageInterface $message
     * @return \Crummy\Phlack\WebHook\Reply\EmptyReply
     */
    protected function send(MessageInterface $message)
    {
        return $this->responder->send($message);
    }
}
