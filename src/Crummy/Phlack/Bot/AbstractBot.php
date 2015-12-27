<?php

namespace Crummy\Phlack\Bot;

use Crummy\Phlack\Common\Exception\InvalidArgumentException;
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
    public function __construct($matcher = null, $options = [])
    {
        if (!$matcher) {
            $matcher = new Matcher\DefaultMatcher();
        }

        $this->setMatcher($matcher);
        $this->responder = $options instanceof ResponderInterface ? $options : new Iterocitor($options);
    }

    /**
     * @param Matcher\MatcherInterface $matcher
     *
     * @throws \Crummy\Phlack\Common\Exception\InvalidArgumentException When given an invalid matcher.
     *
     * @return $this
     */
    public function setMatcher($matcher)
    {
        if (!$matcher instanceof Matcher\MatcherInterface && !is_callable($matcher)) {
            throw new InvalidArgumentException(sprintf(
                'The matcher must be callable, or implement \Crummy\Phlack\Common\Matcher\MatcherInterface. "%" given.',
                is_object($matcher) ? get_class($matcher) : gettype($matcher)
            ));
        }

        $this->matcher = $matcher;

        return $this;
    }

    /**
     * @return Matcher\MatcherInterface|callable
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * @param string $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    protected function say($text)
    {
        return $this->responder->say($text);
    }

    /**
     * @param string $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    protected function emote($text)
    {
        return $this->responder->emote($text);
    }

    /**
     * @param string $user The user_id to tell
     * @param string $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    protected function tell($user, $text)
    {
        return $this->responder->tell($user, $text);
    }

    /**
     * @param \Crummy\Phlack\WebHook\CommandInterface $user The user_id, or a CommandInterface to inspect.
     * @param string                                  $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    protected function reply($user, $text)
    {
        return $this->responder->reply($user, $text);
    }

    /**
     * @param string $text
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    protected function shout($text)
    {
        return $this->responder->shout($text);
    }

    /**
     * @param MessageInterface $message
     *
     * @return \Crummy\Phlack\WebHook\Reply\EmptyReply
     */
    protected function send(MessageInterface $message)
    {
        return $this->responder->send($message);
    }
}
