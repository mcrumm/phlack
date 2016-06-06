<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Event;
use Crummy\Phlack\Common\Events;
use Crummy\Phlack\Common\Exception\InvalidArgumentException;
use Crummy\Phlack\WebHook\Matcher\MatcherAggregate;
use Crummy\Phlack\WebHook\Matcher\MatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Mainframe implements MainframeInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Mainframe constructor.
     *
     * @param EventDispatcherInterface|null $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher = null)
    {
        $this->dispatcher = $dispatcher ?: new EventDispatcher();

        $this->dispatcher->addSubscriber(new Plugin\EncoderPlugin());
    }

    /**
     * @param Command $command
     *
     * @return Event
     */
    public function execute(Command $command)
    {
        $event = new Event(['command' => $command]);

        $this->dispatcher->dispatch(Events::RECEIVED_COMMAND, $event);

        $this->dispatcher->dispatch(Events::AFTER_EXECUTE_COMMAND, $event);

        return $event['message'];
    }

    /**
     * @param Executable                $assistant
     * @param MatcherInterface|callable $matcher   If callable, it should accept a Command and return a boolean.
     * @param int                       $priority
     *
     * @return self
     */
    public function attach(Executable $assistant, $matcher = null, $priority = 0)
    {
        if (!$matcher && $assistant instanceof MatcherAggregate) {
            $matcher = $assistant->getMatcher();
        } else {
            $matcher = function () {
                return true;
            };
        }

        $this->dispatcher->addListener(Events::RECEIVED_COMMAND, $this->getListener($assistant, $matcher), $priority);

        return $this;
    }

    /**
     * @param Executable                $assistant
     * @param MatcherInterface|callable $matcher   If callable, it should accept a Command and return a boolean.
     *
     * @throws \Crummy\Phlack\Common\Exception\InvalidArgumentException When given an invalid matcher.
     *
     * @return \Closure An anonymous function to be attached to the internal cpu.
     */
    public function getListener(Executable $assistant, $matcher)
    {
        if (!$matcher instanceof MatcherInterface && !is_callable($matcher)) {
            throw new InvalidArgumentException(sprintf(
                'The matcher must be callable, or an instance of MatcherInterface. "%s" given.',
                is_object($matcher) ? get_class($matcher) : gettype($matcher)
            ));
        }

        return function (Event $event) use ($assistant, $matcher) {
            if ($matcher instanceof MatcherInterface) {
                $isMatch = $matcher->matches($event['command']);
            } else {
                $isMatch = call_user_func($matcher, $event['command']);
            }

            if ($isMatch) {
                $event->stopPropagation();
                $event['message'] = $assistant->execute($event['command']);
            }
        };
    }
}
