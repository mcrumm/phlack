<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Event;
use Crummy\Phlack\Common\Events;
use Crummy\Phlack\WebHook\Mainframe\ListenerFactory;
use Crummy\Phlack\WebHook\Mainframe\Plugin\EncoderPlugin;
use Crummy\Phlack\WebHook\Matcher\DefaultMatcher;
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
     * @var ListenerFactory
     */
    private $listenerFactory;

    /**
     * Mainframe constructor.
     *
     * @param EventDispatcherInterface|null $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher = null)
    {
        $this->dispatcher = $dispatcher ?: new EventDispatcher();

        $this->dispatcher->addSubscriber(new EncoderPlugin());

        $this->listenerFactory = new ListenerFactory();
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
        $matcher = $matcher ?: $this->getMatcherForExecutable($assistant);

        $listener = $this->listenerFactory->newListener($assistant, $matcher);

        $this->dispatcher->addListener(Events::RECEIVED_COMMAND, $listener, $priority);

        return $this;
    }

    /**
     * @param Executable $assistant
     *
     * @return MatcherInterface
     */
    protected function getMatcherForExecutable(Executable $assistant)
    {
        return $assistant instanceof MatcherAggregate
            ? $assistant->getMatcher()
            : new DefaultMatcher();
    }
}
