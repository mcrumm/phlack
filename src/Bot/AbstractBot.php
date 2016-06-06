<?php

namespace Crummy\Phlack\Bot;

use Crummy\Phlack\Common\Exception\InvalidArgumentException;
use Crummy\Phlack\Common\Formatter\Sequencer;
use Crummy\Phlack\Message\Message;
use Crummy\Phlack\WebHook\Command;
use Crummy\Phlack\WebHook\Matcher;

abstract class AbstractBot implements BotInterface, Matcher\MatcherAggregate
{
    /**
     * @var Sequencer
     */
    protected $sequencer;

    /**
     * @var Matcher\MatcherInterface|callable
     */
    private $matcher;

    /**
     * @param Matcher\MatcherInterface|callable $matcher
     */
    public function __construct($matcher = null)
    {
        $this->sequencer = new Sequencer();

        if (!$matcher) {
            $matcher = new Matcher\DefaultMatcher();
        }
        $this->setMatcher($matcher);
    }

    /**
     * @param Matcher\MatcherInterface|callable $matcher
     *
     * @throws InvalidArgumentException When given an invalid matcher.
     *
     * @return $this
     */
    public function setMatcher($matcher)
    {
        if (!$matcher instanceof Matcher\MatcherInterface && !is_callable($matcher)) {
            throw new InvalidArgumentException(sprintf(
                'The matcher must be callable, or implement \Crummy\Phlack\WebHook\Matcher\MatcherInterface. "%" given.',
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
     * @return Message
     */
    protected function say($text)
    {
        return new Message($text);
    }

    /**
     * @param string $text
     *
     * @return Message
     */
    protected function emote($text)
    {
        return $this->important('channel', $text);
    }

    /**
     * @param string $user The user_id to tell
     * @param string $text
     *
     * @return Message
     */
    protected function tell($user, $text)
    {
        return $this->say($this->sequencer->format('@'.$user).' '.$text);
    }

    /**
     * @param Command $user The user_id, or a Command to inspect.
     * @param string  $text
     *
     * @return Message
     */
    protected function reply($user, $text)
    {
        if ($user instanceof Command) {
            $sequence = $this->sequencer->command($user);

            return $this->say($sequence['user'].' '.$text);
        }

        return $this->tell($user, $text);
    }

    /**
     * @param string $text
     *
     * @return Message
     */
    protected function shout($text)
    {
        return $this->important('everyone', $text);
    }

    /**
     * @param string $where
     * @param string $text
     *
     * @return Message
     */
    protected function important($where, $text)
    {
        return $this->say($this->sequencer->alert($where).' '.$text);
    }
}
