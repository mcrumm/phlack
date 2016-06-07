<?php

namespace Crummy\Phlack\WebHook\Mainframe;

use Crummy\Phlack\Common\Event;
use Crummy\Phlack\Common\Exception\UnexpectedTypeException;
use Crummy\Phlack\WebHook\Executable;
use Crummy\Phlack\WebHook\Matcher\MatcherInterface;

class ListenerFactory
{
    /**
     * @param Executable                $assistant
     * @param MatcherInterface|callable $matcher   If callable, it should accept a Command and return a boolean.
     *
     * @throws UnexpectedTypeException When given an invalid matcher.
     *
     * @return \Closure An anonymous function to be attached to an EventDispatcher.
     */
    public function newListener(Executable $assistant, $matcher)
    {
        if (!$matcher instanceof MatcherInterface && !is_callable($matcher)) {
            throw new UnexpectedTypeException($matcher, [
                'callable',
                'Crummy\Phlack\WebHook\Matcher\MatcherInterface',
            ]);
        }

        return function (Event $event) use ($assistant, $matcher) {
            if ($matcher instanceof MatcherInterface) {
                $isMatch = $matcher->matches($event['command']);
            } else {
                $isMatch = $matcher($event['command']);
            }

            if ($isMatch) {
                $event->stopPropagation();
                $event['message'] = $assistant->execute($event['command']);
            }
        };
    }
}
